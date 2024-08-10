<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Detail Surat</h1>
    <p><strong>No Surat:</strong> <?= $surat['no_surat']; ?></p>
    <p><strong>No Disposisi:</strong> <?= $surat['no_disposisi']; ?></p>
    <p><strong>Tanggal Surat:</strong> <?= $surat['tgl_surat']; ?></p>
    <p><strong>Perihal:</strong> <?= $surat['perihal']; ?></p>
    <!-- Tambahkan detail surat lainnya sesuai kebutuhan -->
    <a href="<?= site_url('admin/daftar_surat'); ?>" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
