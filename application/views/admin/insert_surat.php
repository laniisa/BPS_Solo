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
                    <h1>Edit Surat</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('index') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" style="color: lightgrey;"><a href="<?= site_url('admin/surat') ?>">Daftar Surat</a></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
<section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Insert Surat</h3>
                        </div>
        
        <form action="<?= site_url('admin/save_surat'); ?>" method="post" enctype="multipart/form-data">
        <div class="card-body">
            <div class="form-group">
                <label for="no_surat">No Surat:</label>
                <input type="text" class="form-control" id="no_surat" name="no_surat" required>
            </div>
            <div class="form-group">
                <label for="tgl_surat">Tanggal Surat:</label>
                <input type="date" class="form-control" id="tgl_surat" name="tgl_surat" required>
            </div>
            <div class="form-group">
                <label for="tgl_input">Tanggal Input:</label>
                <input type="date" class="form-control" id="tgl_input" name="tgl_input" value="<?= date('Y-m-d'); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="perihal">Perihal:</label>
                <textarea class="form-control" id="perihal" name="perihal" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="asal">Asal:</label>
                <input type="text" class="form-control" id="asal" name="asal" required>
            </div>
            <div class="form-group">
                <label for="jenis_surat">Jenis Surat:</label>
                <input type="text" class="form-control" id="jenis_surat" name="jenis_surat" required>
            </div>
            <div class="form-group">
                <label for="berkas">Berkas:</label>
                <input type="file" class="form-control" id="berkas" name="berkas" accept=".pdf" required>
            </div>
            <div class="form-group">
                <label for="user_id">Tujuan:</label>
                <select class="form-control" id="user_id" name="user_id">
                    <?php foreach ($kepala as $user): ?>
                        <option value="<?= $user['id_user']; ?>"><?= $user['nama']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="status" value="masuk">
            <a href="<?= site_url('admin/surat'); ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Tambah Surat</button>
                    </div>
                </form>
        </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>
