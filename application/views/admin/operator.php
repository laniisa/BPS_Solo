<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #ffffff;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 style="color: black;">Daftar User</h1> <!-- Ganti warna teks menjadi hitam -->
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= site_url('admin/index') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="<?= site_url('admin') ?>">Daftar Users</a></li> <!-- Hilangkan style color dari breadcrumb -->
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
              <a href="<?= base_url('admin/insert_op') ?>" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Tambah User</a>
              <div class="float-right">
                <a href="#" id="filter-all" class="btn btn-secondary">All</a>
                <a href="#" id="filter-admin" class="btn btn-secondary">Admin</a>
                <a href="#" id="filter-struktural" class="btn btn-secondary">Struktural</a>
                <a href="#" id="filter-fungsional" class="btn btn-secondary">Fungsional</a>
                <a href="#" id="filter-operator" class="btn btn-secondary">Operator</a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="user-table-container">
              <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                <thead style="text-align: center;">
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>WhatsApp</th>
                    <th>Status</th>
                    <th>Konfirmasi</th>
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
                      <td><?= $user['usr'] ?></td>
                      <td><?= $user['email'] ?></td>
                      <td><?= $user['whatsApp'] ?></td>
                      <td>
                        <form action="<?= base_url('admin/edit_status/' . $user['id_user']); ?>" method="POST">
                          <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="active" <?= $user['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?= $user['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                          </select>
                        </form>
                      </td>
                      <td>
                        <?php if ($user['status'] == 'active') : ?>
                          <button type="button" class="btn btn-success btn-sm">Active</button>
                        <?php elseif ($user['status'] == 'inactive') : ?>
                          <button type="button" class="btn btn-danger btn-sm">Inactive</button>
                        <?php endif; ?>
                      </td>
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
                    <th>Username</th>
                    <th>Email</th>
                    <th>WhatsApp</th>
                    <th>Status</th>
                    <th>Konfirmasi</th>
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
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.float-right .btn');
    filterButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const role = this.id.replace('filter-', '');
            fetchUsers(role);
        });
    });

    // Fungsi untuk mendapatkan data pengguna
    function fetchUsers(role) {
        fetch(`<?= site_url('admin/filter_user') ?>?role=${role}`)
            .then(response => response.json())
            .then(data => {
                console.log(data); // Tambahkan ini untuk melihat data yang diterima
                renderTable(data);
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Fungsi untuk memperbarui tabel
    function renderTable(users) {
        let tableContent = `
            <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                <thead style="text-align: center;">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>WhatsApp</th>
                        <th>Status</th>
                        <th>Konfirmasi</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">`;

        users.forEach((user, index) => {
            tableContent += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${user.nama}</td>
                    <td>${user.role}</td>
                    <td>${user.usr}</td>
                    <td>${user.email}</td>
                    <td>${user.whatsApp}</td>
                    <td>
                        <form action="<?= base_url('admin/edit_status/') ?>${user.id_user}" method="POST">
                          <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="active" ${user.status == 'active' ? 'selected' : ''}>Active</option>
                            <option value="inactive" ${user.status == 'inactive' ? 'selected' : ''}>Inactive</option>
                          </select>
                        </form>
                    </td>
                    <td>${user.status == 'active' ? '<button type="button" class="btn btn-success btn-sm">Active</button>' : '<button type="button" class="btn btn-danger btn-sm">Inactive</button>'}</td>
                    <td>
                        <a href="<?= base_url('admin/update_op/') ?>${user.id_user}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="<?= base_url('admin/delete_op/') ?>${user.id_user}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>`;
        });

        tableContent += `
                </tbody>
                <tfoot style="text-align: center;">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>WhatsApp</th>
                        <th>Status</th>
                        <th>Konfirmasi</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>`;

        document.getElementById('user-table-container').innerHTML = tableContent;
    }

    // Dapatkan semua pengguna saat halaman dimuat
    fetchUsers('all');
});
</script>
