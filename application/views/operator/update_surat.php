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

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Surat</h3>
                        </div>
                        <!-- form start -->
                        <form method="post" action="<?= site_url('operator/update_surat_action') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="id_ds_surat" value="<?= htmlspecialchars($surat['id_ds_surat'], ENT_QUOTES) ?>">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="no_surat">No Surat</label>
                                    <input type="text" class="form-control" id="no_surat" name="no_surat" value="<?= htmlspecialchars($surat['no_surat'], ENT_QUOTES) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="tgl_surat">Tanggal Surat</label>
                                    <input type="date" class="form-control" id="tgl_surat" name="tgl_surat" value="<?= htmlspecialchars($surat['tgl_surat'], ENT_QUOTES) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="tgl_dilaksanakan">Tanggal Dilaksanakan</label>
                                    <input type="date" class="form-control" id="tgl_dilaksanakan" name="tgl_dilaksanakan" value="<?= htmlspecialchars($surat['tgl_dilaksanakan'], ENT_QUOTES) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="perihal">Perihal</label>
                                    <textarea class="form-control" id="perihal" name="perihal" rows="3" required><?= htmlspecialchars($surat['perihal'], ENT_QUOTES) ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="asal">Asal</label>
                                    <input type="text" class="form-control" id="asal" name="asal" value="<?= htmlspecialchars($surat['asal'], ENT_QUOTES) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_surat">Jenis Surat</label>
                                    <input type="text" class="form-control" id="jenis_surat" name="jenis_surat" value="<?= htmlspecialchars($surat['jenis_surat'], ENT_QUOTES) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="berkas">Berkas</label>
                                    <input type="file" class="form-control" id="berkas" name="berkas" accept=".pdf">
                                    <input type="hidden" name="berkas_lama" value="<?= htmlspecialchars($surat['berkas'], ENT_QUOTES) ?>">
                                    <?php if ($surat['berkas']): ?>
                                        <p>File saat ini: <?= htmlspecialchars($surat['berkas'], ENT_QUOTES) ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <input type="text" class="form-control" id="status" name="status" value="<?= htmlspecialchars($surat['status'], ENT_QUOTES) ?>" required>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <a href="<?= site_url('operator/index') ?>" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Update Surat</button>
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
