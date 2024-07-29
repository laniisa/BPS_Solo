<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #454d55;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 style="color: white;">Daftar Surat</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">Dashboard</a></li>
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
          <div class="card" style="background-color: #343a40; color: white;">
            <div class="card-header">
              <a href="<?= base_url('operator/insert_surat') ?>" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Tambah Surat</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                <thead style="text-align: center;">
                  <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">No Surat</th>
                    <th style="width: 10%;">Tgl Surat</th>
                    <th style="width: 10%;">Perihal</th>
                    <th style="width: 10%;">Asal</th>
                    <th style="width: 10%;">Jenis Surat</th>
                    <th style="width: 10%;">No Disposisi</th>
                    <th style="width: 5%;">Tujuan</th>
                    <th style="width: 10%; text-align: center;">Aksi</th>
                  </tr>
                </thead>
                <tbody style="text-align: center;">
                  <?php $i = 1; ?>
                  <?php foreach ($surat as $row) : ?>
                    <tr>
                      <td><?= $i++; ?></td>
                      <td><?= $row['no_surat'] ?></td>
                      <td><?= $row['tgl_surat'] ?></td>
                      <td><?= $row['tgl_input'] ?></td>
                      <td><?= $row['perihal'] ?></td>
                      <td><?= $row['asal'] ?></td>
                      <td><?= $row['jenis_surat'] ?></td>
                      <td><?= $row['no_disposisi'] . ' - ' . $row['tgl_surat'] ?></td>
                      <td>
                        <select name="tujuan" class="form-control" onchange="updateTujuan(<?= $row['id_ds_surat'] ?>, this.value)">
                          <option value="">Pilih Tujuan</option>
                          <?php foreach ($struktural_users as $user) : ?>
                            <option value="<?= $user['id_user'] ?>" <?= isset($row['tujuan']) && $row['tujuan'] == $user['id_user'] ? 'selected' : ''; ?>><?= $user['nama'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </td>
                      <td>
                        <a href="<?= base_url('operator/update_surat/' . $row['id_ds_surat']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="<?= base_url('operator/delete_surat/' . $row['id_ds_surat']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')"><i class="fas fa-trash"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot style="text-align: center;">
                  <tr>
                    <th>No</th>
                    <th>No Surat</th>
                    <th>Tgl Surat</th>
                    <th>Tgl Input</th>
                    <th>Perihal</th>
                    <th>Asal</th>
                    <th>Jenis Surat</th>
                    <th>No Disposisi</th>
                    <th>Tujuan</th>
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

<script>
function updateTujuan(id, value) {
  $.ajax({
    url: '<?= base_url('operator/update_tujuan') ?>',
    method: 'POST',
    data: { id_ds_surat: id, tujuan: value },
    success: function(response) {
      console.log(response);
    }
  });
}
</script>
