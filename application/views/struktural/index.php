<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #454d55;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 style="color: white;">Daftar Surat</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <?php if ($this->session->flashdata('message')) : ?>
    <div class="alert alert-success">
      <?= $this->session->flashdata('message'); ?>
    </div>
  <?php endif; ?>
  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card" style="background-color: #343a40; color: white;">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                <thead style="background-color: #6c757d; color: white;">
                  <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">No Surat</th>
                    <th style="width: 10%;">Perihal</th>
                    <th style="width: 10%;">Asal</th>
                    <th style="width: 10%;">Tindak Lanjut</th>
                    <th style="width: 10%;">Konfirmasi</th>
                    <th style="width: 10%;">Dokumen</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($surat as $row) : ?>
                    <tr>
                      <td><?= $i++; ?></td>
                      <td><?= $row['no_surat'] ?></td>
                      <td><?= $row['perihal'] ?></td>
                      <td><?= $row['asal'] ?></td>
                      <td>
                        <?php if (isset($user['id_user'])): ?>
                          <form action="<?= base_url('struktural/edit_status/' . $user['id_user']); ?>" method="POST">
                            <select name="tindal_lanjut" class="form-control" onchange="this.form.submit()">
                              <option value="masuk" <?= $user['tindak_lanjut'] == 'masuk' ? 'selected' : ''; ?>>Masuk</option>
                              <option value="dilaksanakan" <?= $user['tindak_lanjut'] == 'dilaksanakan' ? 'selected' : ''; ?>>Dilaksanakan</option>
                              <option value="diteruskan" <?= $user['tindak_lanjut'] == 'diteruskan' ? 'selected' : ''; ?>>Diteruskan</option>
                            </select>
                          </form>
                        <?php else: ?>
                          <p>User data not available</p>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ($user['tindak_lanjut'] == 'dilaksanakan') : ?>
                          <button type="button" class="btn btn-success btn-sm">Dilaksanakan</button>
                        <?php elseif ($user['tindak_lanjut'] == 'diteruskan') : ?>
                          <button type="button" class="btn btn-danger btn-sm">Diteruskan</button>
                        <?php endif; ?>
                      </td>
                      <td>
                        <a href="<?= base_url('operator/delete_surat/' . $row['id_ds_surat']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')"><i class="fas fa-trash"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot style="background-color: #6c757d; color: white;">
                  <tr>
                    <th>No</th>
                    <th>No Surat</th>
                    <th>Perihal</th>
                    <th>Asal</th>
                    <th>Tindak Lanjut</th>
                    <th>Konfirmasi</th>
                    <th>Dokumen</th>
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
