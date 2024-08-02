<!DOCTYPE html>
<html>
<head>
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2><?= $title; ?></h2>
        <form action="<?= site_url('admin/update_surat/' . $surat['id_ds_surat']); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="no_disposisi">No Disposisi:</label>
                <input type="text" class="form-control" id="no_disposisi" name="no_disposisi" value="<?= $surat['no_disposisi']; ?>">
            </div>
            <div class="form-group">
                <label for="no_surat">No Surat:</label>
                <input type="text" class="form-control" id="no_surat" name="no_surat" value="<?= $surat['no_surat']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tgl_surat">Tanggal Surat:</label>
                <input type="date" class="form-control" id="tgl_surat" name="tgl_surat" value="<?= $surat['tgl_surat']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tgl_disposisi">Tanggal Disposisi:</label>
                <input type="date" class="form-control" id="tgl_disposisi" name="tgl_disposisi" value="<?= $surat['tgl_disposisi']; ?>">
            </div>
            <div class="form-group">
                <label for="tgl_dilaksanakan">Tanggal Dilaksanakan:</label>
                <input type="date" class="form-control" id="tgl_dilaksanakan" name="tgl_dilaksanakan" value="<?= $surat['tgl_dilaksanakan']; ?>">
            </div>
            <div class="form-group">
                <label for="perihal">Perihal:</label>
                <textarea class="form-control" id="perihal" name="perihal" rows="3" required><?= $surat['perihal']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="asal">Asal:</label>
                <input type="text" class="form-control" id="asal" name="asal" value="<?= $surat['asal']; ?>" required>
            </div>
            <div class="form-group">
                <label for="jenis_surat">Jenis Surat:</label>
                <input type="text" class="form-control" id="jenis_surat" name="jenis_surat" value="<?= $surat['jenis_surat']; ?>" required>
            </div>
            <div class="form-group">
                <label for="berkas">Berkas:</label>
                <input type="file" class="form-control" id="berkas" name="berkas" accept=".pdf">
                <input type="hidden" name="berkas_lama" value="<?= $surat['berkas']; ?>">
                <?php if ($surat['berkas']): ?>
                    <p>File saat ini: <?= $surat['berkas']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" class="form-control" id="status" name="status" value="<?= $surat['status']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Surat</button>
        </form>
    </div>
</body>
</html>
