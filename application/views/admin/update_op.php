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
            <form method="post" action="<?= site_url('admin/update_op/' . $user['id_user']) ?>">
              <div class="card-body">
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($user['nama'], ENT_QUOTES) ?>" required>
                </div>
                <div class="form-group">
                  <label for="role">Role</label>
                  <select class="form-control" id="role" name="role" required>
                    <option value="0" <?= $user['role'] == '0' ? 'selected' : '' ?>>Admin</option>
                    <option value="2" <?= $user['role'] == '2' ? 'selected' : '' ?>>Fungsional</option>
                    <option value="1" <?= $user['role'] == '1' ? 'selected' : '' ?>>Struktural</option>
                    <option value="3" <?= $user['role'] == '3' ? 'selected' : '' ?>>Operator</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control" id="status" name="status" required>
                    <option value="active" <?= $user['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $user['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                  </select>
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
                  <label for="whatsApp">WhatsApp</label>
                  <input type="text" class="form-control" id="whatsApp" name="whatsApp" value="<?= htmlspecialchars($user['whatsApp'], ENT_QUOTES) ?>" required>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password">
                  <small class="form-text text-muted">Leave blank if you do not want to change the password.</small>
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
