<!DOCTYPE html>
<html lang="en">
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
<body>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <?php if ($this->session->flashdata('message')) : ?>
    <?= $this->session->flashdata('message'); ?>
  <?php endif; ?>
  
  <!-- Content Header (Page header) -->
  <section class="content">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Daftar Surat</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= site_url('admin/index') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="<?= site_url('admin/daftar_surat') ?>">Daftar Surat</a></li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h2>Rekapitulasi Surat</h2>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <form id="filter-form" class="form">
                    <div class="form-group mb-2">
                      <label for="tanggal_awal">Tanggal Awal</label>
                      <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                      <label for="tanggal_akhir">Tanggal Akhir</label>
                      <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                      <button type="submit" class="btn btn-primary">Tampilkan</button>
                      <button type="reset" class="btn btn-secondary ml-2" id="reset-button">Reset</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <a href="<?= base_url('admin/insert_surat') ?>" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Tambah Surat</a>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12" id="surat-table-container">
                  <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No</th>
                        <th>No Surat</th>
                        <th>No Disposisi</th>
                        <th>Tgl Surat</th>
                        <th>Tgl Input</th>
                        <th>Tgl Disposisi</th>
                        <th>Tgl Dilaksanakan</th>
                        <th>Perihal</th>
                        <th>Asal</th>
                        <th>Jenis Surat</th>
                        <th>Berkas</th>
                        <th>Status</th>
                        <th style="text-align: center;">Aksi</th>
                      </tr>
                    </thead>
                    <tbody style="text-align: center;">
                      <?php $i = 1; ?>
                      <?php foreach ($surat as $item) : ?>
                        <tr>
                          <td><?= $i++; ?></td>
                          <td><a href="<?= base_url('admin/detail_surat/') . $item['id_ds_surat'] ?>"><?= $item['no_surat']; ?></a></td>
                          <td><?= $item['no_disposisi']; ?></td>
                          <td><?= $item['tgl_surat']; ?></td>
                          <td><?= $item['tgl_input']; ?></td>
                          <td><?= $item['tgl_disposisi']; ?></td>
                          <td><?= $item['tgl_dilaksanakan']; ?></td>
                          <td><?= $item['perihal']; ?></td>
                          <td><?= $item['asal']; ?></td>
                          <td><?= $item['jenis_surat']; ?></td>
                          <td>
                            <?php if ($item['berkas']) : ?>
                                <a href="<?= base_url('uploads/' . $item['berkas']); ?>" class="btn btn-info btn-sm" download>Unduh</a>
                            <?php else : ?>
                                Tidak ada berkas
                            <?php endif; ?>
                          </td>
                          <td><?= $item['status']; ?></td>
                          <td>
                            <a href="<?= base_url('admin/update_surat/' . $item['id_ds_surat']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('admin/delete_surat/' . $item['id_ds_surat']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')"><i class="fas fa-trash"></i></a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot style="text-align: center;">
                      <tr>
                        <th>No</th>
                        <th>No Surat</th>
                        <th>No Disposisi</th>
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
    const form = document.getElementById('filter-form');
    const resetButton = document.getElementById('reset-button');

    // Ketika tombol "Tampilkan" diklik
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const tanggalAwal = document.getElementById('tanggal_awal').value;
        const tanggalAkhir = document.getElementById('tanggal_akhir').value;
        fetchSurat(tanggalAwal, tanggalAkhir);
    });

    // Ketika tombol "Reset" diklik
    resetButton.addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('tanggal_awal').value = '';
        document.getElementById('tanggal_akhir').value = '';
        fetchSurat('', ''); // Menampilkan semua data surat
    });

    // Fungsi untuk mendapatkan data surat berdasarkan tanggal
    function fetchSurat(tanggalAwal, tanggalAkhir) {
        fetch(`<?= site_url('admin/filter_surat') ?>?tanggal_awal=${tanggalAwal}&tanggal_akhir=${tanggalAkhir}`)
            .then(response => response.json())
            .then(data => {
                console.log(data); // Tambahkan ini untuk melihat data yang diterima
                renderTable(data);
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Fungsi untuk memperbarui tabel surat
    function renderTable(surat) {
        if ($.fn.DataTable.isDataTable('#example1')) {
            $('#example1').DataTable().destroy();
        }

        let tableContent = `
            <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                <thead style="text-align: center;">
                    <tr>
                      <th>No</th>
                        <th>No Surat</th>
                        <th>No Disposisi</th>
                        <th>Tgl Surat</th>
                        <th>Tgl Input</th>
                        <th>Tgl Disposisi</th>
                        <th>Tgl Dilaksanakan</th>
                        <th>Perihal</th>
                        <th>Asal</th>
                        <th>Jenis Surat</th>
                        <th>Berkas</th>
                        <th>Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">
        `;

        surat.forEach((item, index) => {
            tableContent += `
                <tr>
                    <td>${index + 1}</td>
                    <td><a href="<?= base_url('admin/detail_surat/') ?>${item.id_ds_surat}">${item.no_surat}</a></td>
                    <td>${item.no_disposisi}</td>
                    <td>${item.tgl_surat}</td>
                    <td>${item.tgl_input}</td>
                    <td>${item.tgl_disposisi}</td>
                    <td>${item.tgl_dilaksanakan}</td>
                    <td>${item.perihal}</td>
                    <td>${item.asal}</td>
                    <td>${item.jenis_surat}</td>
                    <td>
                        ${item.berkas ? `<a href="<?= base_url('uploads/') ?>${item.berkas}" class="btn btn-info btn-sm" download>Unduh</a>` : 'Tidak ada berkas'}
                    </td>
                    <td>${item.status}</td>
                    <td>
                        <a href="<?= base_url('admin/update_surat/') ?>${item.id_ds_surat}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="<?= base_url('admin/delete_surat/') ?>${item.id_ds_surat}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            `;
        });

        tableContent += `
                </tbody>
                <tfoot style="text-align: center;">
                    <tr>
                      <th>No</th>
                        <th>No Surat</th>
                        <th>No Disposisi</th>
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
        `;

        document.getElementById('surat-table-container').innerHTML = tableContent;

        // Inisialisasi ulang DataTable
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

      
    }

    // Memuat semua data surat saat halaman pertama kali dibuka
    fetchSurat('', '');
});
</script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

</body>
</html>
