<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Notifikasi pesan -->
  <?php if ($this->session->flashdata('message')) : ?>
    <?= $this->session->flashdata('message'); ?>
  <?php endif; ?>

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit User</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= site_url('index') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" style="color: lightgrey;"><a href="<?= site_url('admin/operator') ?>">Daftar Users</a></li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit User</h3>
            </div>
            <!-- form start -->
            <form method="post" action="<?= site_url('admin/update_op/' . $user['id_user']) ?>" enctype="multipart/form-data">
              <div class="card-body">
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($user['nama'], ENT_QUOTES) ?>" required>
                </div>

                <div class="form-group">
                  <label for="usr">Username</label>
                  <input type="text" class="form-control" id="usr" name="usr" value="<?= htmlspecialchars($user['usr'], ENT_QUOTES) ?>" required>
                </div>

                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email'], ENT_QUOTES) ?>" required>
                </div>
                
                <div class="form-group">
                  <label for="role">Role</label>
                  <select class="form-control" id="role" name="role" required>
                      <option value="">--Pilih Role--</option>
                      <?php foreach ($roles as $role): ?>
                          <option value="<?= $role['id_user_role']; ?>" <?= $role['id_user_role'] == $user['role'] ? 'selected' : '' ?>>
                            <?= ucfirst($role['role']); ?>
                          </option>
                      <?php endforeach; ?>
                  </select>
                  <?= form_error('role', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control" id="status" name="status" required>
                    <option value="active" <?= $user['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $user['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                  </select>
                </div>
      
                <div class="form-group">
                  <label for="jabatan">Jabatan</label>
                  <select class="form-control" id="jabatan" name="jabatan" required>
                    <option value="kepala" <?= $user['jabatan'] == 'kepala' ? 'selected' : '' ?>>Kepala</option>
                    <option value="staff" <?= $user['jabatan'] == 'staff' ? 'selected' : '' ?>>Staff</option>
                    <option value="lainnya" <?= $user['jabatan'] == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                  </select>
                  <?= form_error('jabatan', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                  <label for="whatsApp">WhatsApp</label>
                  <input type="text" class="form-control" id="whatsApp" name="whatsApp" value="<?= htmlspecialchars($user['whatsApp'], ENT_QUOTES) ?>" required>
                </div>

                <div class="form-group">
                  <label for="foto">Foto</label>
                  <input type="file" class="form-control-file" id="foto" name="foto">
                  <?= form_error('foto', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" >
                  <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                  <label for="password_confirm">Konfirmasi Password</label>
                  <input type="password" class="form-control" id="password_confirm" name="password_confirm" >
                  <?= form_error('password_confirm', '<small class="text-danger">', '</small>'); ?>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <a href="<?= site_url('admin/operator') ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
