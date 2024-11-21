<div class="container-fluid">
    <h2 class="text-center mb-4"><?= $title; ?></h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="<?= base_url('operator/update'); ?>" method="post" enctype="multipart/form-data">
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
                <a href="<?= base_url('operator/profile'); ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
