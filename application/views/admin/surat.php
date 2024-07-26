<head>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/dist/css/adminlte.min.css'); ?>">
</head>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1s>Daftar Surat</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= site_url('admin/save_surat') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" style="color: lightgrey;"><a href="<?= site_url('admin') ?>">Daftar Surat</a></li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <?php if ($this->session->flashdata('message')) : ?>
    <?= $this->session->flashdata('message'); ?>
  <?php endif; ?>
  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card" >
            <div class="card-header">
            <a href="<?= base_url('admin/insert_surat') ?>" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Tambah Surat</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
            <thead style="text-align: center;">
              <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">No Disposisi</th>
                <th style="width: 15%;">No Surat</th>
                <th style="width: 10%;">Tgl Surat</th>
                <th style="width: 10%;">Tgl Input</th>
                <th style="width: 10%;">Tgl Disposisi</th>
                <th style="width: 10%;">Tgl Dilaksanakan</th>
                <th style="width: 10%;">Perihal</th>
                <th style="width: 10%;">Asal</th>
                <th style="width: 10%;">Jenis Surat</th>
                <th style="width: 10%;">Berkas</th>
                <th style="width: 5%;">Status</th>
                <th style="width: 10%; text-align: center;">Aksi</th>
              </tr>
            </thead>
            <tbody style="text-align: center;">
              <?php $i = 1; ?>
              <?php foreach ($surat as $row) : ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $row['no_disposisi'] ?></td>
                  <td><?= $row['no_surat'] ?></td>
                  <td><?= $row['tgl_surat'] ?></td>
                  <td><?= $row['tgl_input'] ?></td>
                  <td><?= $row['tgl_disposisi'] ?></td>
                  <td><?= $row['tgl_dilaksanakan'] ?></td>
                  <td><?= $row['perihal'] ?></td>
                  <td><?= $row['asal'] ?></td>
                  <td><?= $row['jenis_surat'] ?></td>
                  <td><?= $row['berkas'] ?></td>
                  <td><?= $row['status'] ?></td>
                  <td>
                    <a href="<?= base_url('admin/update_surat/' . $row['id']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                    <a href="<?= base_url('admin/delete_surat/' . $row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')"><i class="fas fa-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
              </tbody>
              <tfoot style="text-align: center;">
                <tr>
                  <th>No</th>
                  <th>No Disposisi</th>
                  <th>No Surat</th>
                  <th>Tgl Surat</th>
                  <th>Tgl Input</th>
                  <th>Tgl Disposisi</th>
                  <th>Tgl Dilaksanakan</th>
                  <th>Perihal</th>
                  <th>Asal</th>
                  <th>Jenis Surat</th>
                  <th>Berkas</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </tfoot>
            </table>
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
 <!-- jQuery -->
<script src="<?=base_url("assets/admin/plugins/jquery/jquery.min.js");?>"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url("assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js");?>"></script>
<!-- AdminLTE App -->
<script src="<?=base_url("assets/admin/bootstrap/js/bootstrap.bundle.min.js");?>"></script>dist/js/adminlte.min.js
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url("assets/admin/dist/js/demo.js");?>"></script>
<!-- DataTables & Plugins -->
  <script src="<?= base_url('assets/admin/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
  <script src="<?= base_url('assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
  <script src="<?= base_url('assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
  <script src="<?= base_url('assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
  <script src="<?= base_url('assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
  <script src="<?= base_url('assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
  <script src="<?= base_url('assets/admin/plugins/jszip/jszip.min.js'); ?>"></script>
  <script src="<?= base_url('assets/admin/plugins/pdfmake/pdfmake.min.js'); ?>"></script>
  <script src="<?= base_url('assets/admin/plugins/pdfmake/vfs_fonts.js'); ?>"></script>
  <script src="<?= base_url('assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js'); ?>"></script>
  <script src="<?= base_url('assets/admin/plugins/datatables-buttons/js/buttons.print.min.js'); ?>"></script>
  <script src="<?= base_url('assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js'); ?>"></script>
  <script>
  $(function () {
    $("#example2").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
  });
  </script>