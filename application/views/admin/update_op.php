<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #454d55;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 style="color: white;">Edit User</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= site_url('index') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" style="color: lightgrey;"><a href="<?= site_url('admin_operator') ?>">Daftar Users</a></li>
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
                  <input type="text" class="form-control" id="nama" name="nama" value="<?= $user['nama'] ?>" required>
                </div>
                <div class="form-group">
                  <label for="role">Role</label>
                  <select class="form-control" id="role" name="role" required>
                    <option value="Admin" <?= $user['role'] == '0' ? 'selected' : '' ?>>Admin</option>
                    <option value="Fungsional" <?= $user['role'] == '1' ? 'selected' : '' ?>>Fungsional</option>
                    <option value="Struktural" <?= $user['role'] == '2' ? 'selected' : '' ?>>Struktural</option>
                    <option value="Operator" <?= $user['role'] == '3' ? 'selected' : '' ?>>Operator</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control" id="status" name="status" required>
                    <option value="Active" <?= $user['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                    <option value="Inactive" <?= $user['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="usr">Username</label>
                  <input type="text" class="form-control" id="usr" name="usr" value="<?= $user['usr'] ?>" required>
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
                </div>
                <div class="form-group">
                  <label for="whatsApp">WhatsApp</label>
                  <input type="text" class="form-control" id="whatsApp" name="whatsApp" value="<?= $user['whatsApp'] ?>" required>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" value="<?= $user['password'] ?>" required>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
              <a href="<?= site_url('admin/operator'); ?>" class="btn btn-secondary">Batal</a>
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
