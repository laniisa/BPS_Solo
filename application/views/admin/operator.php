<!-- Content Wrapper. Contains page content -->
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>

<div class="content-wrapper">
  <?php if ($this->session->flashdata('message')) : ?>
    <?= $this->session->flashdata('message'); ?>
  <?php endif; ?>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Daftar User</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= site_url('admin/index') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="<?= site_url('admin') ?>">Daftar Users</a></li>
          </ol>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card" style="background-color: #f8f9fa;"> <!-- Background card menjadi lebih terang -->
            <div class="card-header">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 style="color: black;">Daftar User</h1> <!-- Teks hitam -->
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= site_url('admin/index') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="<?= site_url('admin') ?>">Daftar Users</a></li>
                  </ol>
                </div>
              </div>
            </div>
            <div class="card-header">
              <a href="<?= base_url('admin/insert_op') ?>" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Tambah User</a>
              <div class="float-right">
                <a href="#" id="filter-all" class="btn btn-secondary">All</a>
                <a href="#" id="filter-admin" class="btn btn-secondary">Admin</a>
                <a href="#" id="filter-struktural" class="btn btn-secondary">Struktural</a>
                <a href="#" id="filter-fungsional" class="btn btn-secondary">Fungsional</a>
                <a href="#" id="filter-operator" class="btn btn-secondary">Operator</a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-12" id="user-table-container">
                  <!-- Tabel akan dimuat di sini oleh JavaScript -->
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.float-right .btn');

    filterButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            // Tentukan nilai role berdasarkan id button
            let role;
            switch (this.id) {
                case 'filter-all': role = 'all'; break;
                case 'filter-admin': role = '0'; break;        
                case 'filter-struktural': role = '1'; break;   
                case 'filter-fungsional': role = '2'; break;   
                case 'filter-operator': role = '3'; break;     
                default: role = 'all';
            }

            fetchUsers(role);
        });
    });

    function fetchUsers(role) {
        fetch(`<?= site_url('admin/filter_user') ?>?role=${role}`)
            .then(response => response.json())
            .then(data => {
                renderTable(data);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    

  

    // Fungsi untuk memperbarui tabel
    function renderTable(users) {
        console.log('Rendering table with users:', users); // Debugging data users

        if ($.fn.DataTable.isDataTable('#example1')) {
            $('#example1').DataTable().destroy();
        }

        let tableContent = `
            <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                <thead style="text-align: center;">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>WhatsApp</th>
                        <th>Status</th>
                        <th>Konfirmasi</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">`;

        users.forEach((user, index) => {
            tableContent += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${user.nama}</td>
                    <td>${user.usr}</td>
                    <td>${user.email}</td>
                    <td>${user.whatsApp}</td>
                    <td>
                        <form action="<?= base_url('admin/edit_status/') ?>${user.id_user}" method="POST">
                          <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="active" ${user.status == 'active' ? 'selected' : ''}>Active</option>
                            <option value="inactive" ${user.status == 'inactive' ? 'selected' : ''}>Inactive</option>
                          </select>
                        </form>
                    </td>
                    <td>${user.status == 'active' ? '<button type="button" class="btn btn-success btn-sm">Active</button>' : '<button type="button" class="btn btn-danger btn-sm">Inactive</button>'}</td>
                    
                    <td>
                        <a href="<?= base_url('admin/update_op/') ?>${user.id_user}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="<?= base_url('admin/delete_op/') ?>${user.id_user}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>`;
        });

        tableContent += `
                
            </table>`;

        document.getElementById('user-table-container').innerHTML = tableContent;

        $('#example1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copy',
            exportOptions: {
                columns: ':not(.no-export)' // Mengatur agar kolom dengan class 'no-export' tidak diekspor
            }
        },
        {
            extend: 'csv',
            exportOptions: {
                columns: ':not(.no-export)' // Mengatur agar kolom dengan class 'no-export' tidak diekspor
            }
        },
        {
            extend: 'excel',
            exportOptions: {
                columns: ':not(.no-export)' // Mengatur agar kolom dengan class 'no-export' tidak diekspor
            }
        },
        {
            extend: 'pdf',
            exportOptions: {
                columns: ':not(.no-export)' // Mengatur agar kolom dengan class 'no-export' tidak diekspor
            }
        },
        {
            extend: 'print',
            exportOptions: {
                columns: ':not(.no-export)' // Mengatur agar kolom dengan class 'no-export' tidak diekspor
            }
        },
        {
            extend: 'colvis',
            text: 'Column visibility'
        }
    ],
    columnDefs: [
        {
            targets: [5, 7], // Kolom Status dan Aksi (indeks 5 dan 6)
            className: 'no-export' // Menandai kolom yang tidak akan diekspor
        }
    ]
});



    }

    // Dapatkan semua pengguna saat halaman dimuat
    fetchUsers('all');
});

</script>
