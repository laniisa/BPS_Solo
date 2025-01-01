<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2>DISPOSISI | Dashboard</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="<?= site_url('admin') ?>">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <a href="<?= base_url('admin/surat'); ?>" class="text-decoration-none">
                        <div class="info-box shadow-lg" style="background-color: #6C63FF; color: white;">
                            <span class="info-box-icon elevation-1"><i class="fas fa-envelope"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Jumlah Surat</span>
                                <span class="info-box-number" style="font-size: 2rem;"><?= $jumlah_surat ?> Surat</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <a href="<?= base_url('admin/operator'); ?>" class="text-decoration-none">
                        <div class="info-box shadow-lg" style="background-color: #FF6F61; color: white;">
                            <span class="info-box-icon elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Jumlah User</span>
                                <span class="info-box-number" style="font-size: 2rem;"><?= $total_users ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pengguna Berdasarkan Role</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="chartUserRole" height="150"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxUserRole = document.getElementById('chartUserRole').getContext('2d');
    new Chart(ctxUserRole, {
        type: 'bar',
        data: {
            labels: ['Admin', 'Operator', 'Struktural', 'Fungsional'],
            datasets: [{
                label: 'Jumlah Pengguna',
                data: <?= json_encode($data_user_roles) ?>,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)',
                    'rgba(255, 99, 132, 0.6)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: { enabled: true }
            },
            scales: {
                x: { beginAtZero: true },
                y: { beginAtZero: true }
            }
        }
    });
</script>
