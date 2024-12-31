<div class="content-wrapper">
    <!-- Notifikasi pesan -->
    <?php if ($this->session->flashdata('message')) : ?>
        <?= $this->session->flashdata('message'); ?>
    <?php endif; ?>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                   
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('admin/index') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" style="color: lightgrey;"><a href="<?= site_url('admin/profile') ?>">Profile</a></li>
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
                            <h3 class="card-title">Edit profile</h3>
                        </div>



            <form action="<?= base_url('admin/update'); ?>" method="post" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= $user['nama']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $user['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="whatsApp">WhatsApp</label>
                    <input type="text" name="whatsApp" class="form-control" value="<?= $user['whatsApp']; ?>">
                </div>
                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" value="<?= $user['jabatan']; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password_confirm">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirm" class="form-control">
                </div>
                <div class="form-group">
                    <label for="foto">Foto Profil</label>
                    <input type="file" name="foto" class="form-control">
                </div>
                <input type="hidden" name="old_foto" value="<?= $user['foto']; ?>">
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="<?= base_url('admin/profile'); ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
        </div>
    </div>
    </div>
    </div>
    </section>
</div>
