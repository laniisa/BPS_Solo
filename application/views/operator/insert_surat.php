<!DOCTYPE html>
<html>
<head>
    <title><?= $title; ?></title>
    <!-- Include Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2><?= $title; ?></h2>
        <!-- Display flash message -->
        <?php if ($this->session->flashdata('message')): ?>
            <?= $this->session->flashdata('message'); ?>
        <?php endif; ?>
        <form action="<?= site_url('operator/save_surat'); ?>" method="post" enctype="multipart/form-data">
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
        <label for="tujuan_id">Tujuan:</label>
        <select class="form-control" id="tujuan_id" name="tujuan_id" required>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id']; ?>"><?= $user['nama']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Tambah Surat</button>
</form>

    <!-- Include Bootstrap JS for interactive components -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
