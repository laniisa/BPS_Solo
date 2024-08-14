<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Rekapitulasi Tindak Lanjut Surat</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('admin/save_surat') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="<?= site_url('admin/rekap_surat') ?>">Rekapitulasi Tindak Lanjut Surat</a></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h2>REKAP DISPOSISI</h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="get" action="">
                        <div class="form-group row">
                            <label for="bulan" class="col-sm-1 col-form-label">Bulan:</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="bulan" name="bulan" value="<?= $bulan ?>" min="1" max="12">
                            </div>
                            <label for="tahun" class="col-sm-1 col-form-label">Tahun:</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="tahun" name="tahun" value="<?= $tahun ?>" min="2000" max="<?= date('Y') ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-primary">Tampilkan</button>
                                <button type="button" class="btn btn-secondary ml-2" id="reset-button">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h4>Rekap Tindak Lanjut Surat <?= $bulan ? $bulan : 'Semua' ?> <?= $tahun ? $tahun : '' ?></h4>
                    <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                        <thead style="text-align: center;">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Masuk</th>
                                <th>Dilaksanakan</th>
                                <th>Didisposisi</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            <?php if (count($rekap) > 0): ?>
                                <?php foreach ($rekap as $index => $item): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= $item['nama'] ?></td>
                                        <td><?= $item['masuk'] ?></td>
                                        <td><?= $item['dilaksanakan'] ?></td>
                                        <td><?= $item['diteruskan'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    document.getElementById('reset-button').addEventListener('click', function() {
        // Clear the form fields
        document.getElementById('bulan').value = '';
        document.getElementById('tahun').value = '';

        // Redirect to the current URL without query parameters to show all data
        window.location.href = window.location.pathname;
    });

    $('#example1').DataTable({
            paging: true,
            lengthChange: false,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,

            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
                {
                extend: 'colvis',
                text: 'Column visibility'
            }
            ]
        });
</script>
