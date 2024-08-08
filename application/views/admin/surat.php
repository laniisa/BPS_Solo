<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #ffffff;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 style="color: black;">Daftar Surat</h1> <!-- Ganti warna teks menjadi hitam -->
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= site_url('admin/save_surat') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="<?= site_url('admin') ?>">Daftar Surat</a></li> <!-- Hilangkan style color dari breadcrumb -->
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
          <div class="card" style="background-color: #ffffff; color: black;"> <!-- Ganti warna background card dan teks -->
            <div class="card-header">
              <a href="<?= base_url('admin/insert_surat') ?>" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Tambah Surat</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                <thead style="text-align: center;">
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
                    <th style="text-align: center;">Aksi</th>
                  </tr>
                </thead>
                <tbody style="text-align: center;">
                  <?php $i = 1; ?>
                  <?php foreach ($surat as $row) : ?>
                    <tr>
                      <td><?= $i++; ?></td>
                      <td><?= $row['no_disposisi'] . ' - ' . date('Y', strtotime($row['tgl_surat'])) ?></td>
                      <td><?= $row['no_surat'] ?></td>
                      <td><?= $row['tgl_surat'] ?></td>
                      <td><?= $row['tgl_input'] ?></td>
                      <td><?= $row['tgl_disposisi'] ?></td>
                      <td><?= $row['tgl_dilaksanakan'] ?></td>
                      <td><?= $row['perihal'] ?></td>
                      <td><?= $row['asal'] ?></td>
                      <td><?= $row['jenis_surat'] ?></td>
                      <td>
                        <?php if (!empty($row['berkas'])) : ?>
                          <a href="<?= base_url('uploads/' . $row['berkas']) ?>" class="btn btn-info btn-sm" download>Unduh</a>
                        <?php else : ?>
                          <span class="text-muted">Tidak ada berkas</span>
                        <?php endif; ?>
                      </td>
                      <td><?= $row['status'] ?></td>
                      <td>
                        <a href="<?= base_url('admin/update_surat/' . $row['id_ds_surat']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="<?= base_url('admin/delete_surat/' . $row['id_ds_surat']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')"><i class="fas fa-trash"></i></a>
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
