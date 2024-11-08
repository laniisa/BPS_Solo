<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" >
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 >Tambah User</h1>
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
              <h3 class="card-title">Tambah User</h3>
            </div>
            <!-- form start -->
            <div class="container mt-5">
              <h2>Tambah User</h2>
              <?= $this->session->flashdata('message'); ?>
              <form action="<?= base_url('admin/insert_user'); ?>" method="post" enctype="multipart/form-data">
                  
                  <div class="form-group">
                      <label for="nama">Nama</label>
                      <input type="text" class="form-control" id="nama" name="nama" required>
                      <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                  </div>
                  
                  <div class="form-group">
                      <label for="usr">Username</label>
                      <input type="text" class="form-control" id="usr" name="usr" required>
                      <?= form_error('usr', '<small class="text-danger">', '</small>'); ?>
                  </div>
                  
                  <div class="form-group">
                      <label for="role">Role</label>
                      <select class="form-control" id="role" name="role" required>
                          <option value="">--Select Role--</option>
                          <?php foreach ($roles as $role): ?>
                              <option value="<?= $role['id_user_role']; ?>"><?= ucfirst($role['role']); ?></option>
                          <?php endforeach; ?>
                      </select>
                      <?= form_error('role', '<small class="text-danger">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" id="email" name="email" required>
                      <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                  </div>
                  
                  <div class="form-group">
                      <label for="whatsApp">WhatsApp</label>
                      <input type="text" class="form-control" id="whatsApp" name="whatsApp" required>
                      <?= form_error('whatsApp', '<small class="text-danger">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <select class="form-control" id="jabatan" name="jabatan" required>
                      <option value="kepala">Kepala</option>
                      <option value="staff">Staff</option>
                      <option value="lainnya">lainnya</option>
                    </select>
                    <?= form_error('jabatan', '<small class="text-danger">', '</small>'); ?>

                  </div> 

                  <div class="form-group">
                      <label for="status">Status</label>
                      <select class="form-control" id="status" name="status" required>
                          <option value="active">Active</option>
                          <option value="inactive">Inactive</option>
                      </select>
                      <?= form_error('status', '<small class="text-danger">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                      <label for="foto">Foto</label>
                      <input type="file" class="form-control-file" id="foto" name="foto">
                      <?= form_error('foto', '<small class="text-danger">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" id="password" name="password" required>
                      <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                      <label for="password_confirm">Konfirmasi Password</label>
                      <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                      <?= form_error('password_confirm', '<small class="text-danger">', '</small>'); ?>
                  </div>

                  <button type="submit" class="btn btn-primary">Add User</button>
              </form>
          </div>

          </div>
          <!-- /.card -->
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
