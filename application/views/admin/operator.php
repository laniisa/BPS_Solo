<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #454d55;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 style="color: white;">Daftar Users</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= site_url('admin/index') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" style="color: lightgrey;"><a href="<?= site_url('admin') ?>">Daftar Users</a></li>
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
              <a href="<?= base_url('admin/insert_op') ?>" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Tambah User</a>
              <div class="float-right">
                <a href="<?= site_url('users?role=all') ?>" class="btn btn-secondary">All</a>
                <a href="<?= site_url('users?role=admin') ?>" class="btn btn-secondary">Admin</a>
                <a href="<?= site_url('users?role=struktural') ?>" class="btn btn-secondary">Struktural</a>
                <a href="<?= site_url('users?role=fungsional') ?>" class="btn btn-secondary">Fungsional</a>
                <a href="<?= site_url('users?role=operator') ?>" class="btn btn-secondary">Operator</a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                <thead style="text-align: center;">
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>WhatsApp</th>
                    <th style="text-align: center;">Aksi</th>
                  </tr>
                </thead>
                <tbody style="text-align: center;">
                  <?php $i = 1; ?>
                  <?php foreach ($users as $user) : ?>
                    <tr>
                      <td><?= $i++; ?></td>
                      <td><?= $user['nama'] ?></td>
                      <td><?= $user['role'] ?></td>
                      <td><?= $user['status'] ?></td>
                      <td><?= $user['usr'] ?></td>
                      <td><?= $user['email'] ?></td>
                      <td><?= $user['whatsApp'] ?></td>
                      <td>
                        <a href="<?= base_url('admin/update_op/' . $user['id_user']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="<?= base_url('admin/delete_op/' . $user['id_user']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"><i class="fas fa-trash"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot style="text-align: center;">
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>WhatsApp</th>
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
