<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-left: 250px; /* Adjust padding for sidebar width */
        }
        /* Make the sidebar fixed if it is present */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
            border-right: 1px solid #ddd;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <!-- Sidebar content here, e.g., links, menu, etc. -->
        <h4>Sidebar</h4>
        <ul>
            <li><a href="#">Menu Item 1</a></li>
            <li><a href="#">Menu Item 2</a></li>
            <li><a href="#">Menu Item 3</a></li>
        </ul>
    </div>

    <div class="container content mt-5">
        <h2><?= $title; ?></h2>
        <?php if ($this->session->flashdata('message')): ?>
            <?= $this->session->flashdata('message'); ?>
        <?php endif; ?>
        <form action="<?= site_url('operator/update_surat_action'); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $surat['id_ds_surat']; ?>">

            <div class="form-group">
                <label for="no_surat">No Surat:</label>
                <input type="text" class="form-control" id="no_surat" name="no_surat" value="<?= $surat['no_surat']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tgl_surat">Tanggal Surat:</label>
                <input type="date" class="form-control" id="tgl_surat" name="tgl_surat" value="<?= $surat['tgl_surat']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tgl_input">Tanggal Input:</label>
                <p class="form-control-plaintext"><?= $surat['tgl_input']; ?></p>
                <input type="hidden" name="tgl_input" value="<?= $surat['tgl_input']; ?>">
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
                    <p>File saat ini: <a href="<?= base_url('uploads/' . $surat['berkas']); ?>" target="_blank"><?= $surat['berkas']; ?></a></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="user_id">Tujuan:</label>
                <select class="form-control" id="user_id" name="user_id">
                    <?php foreach ($kepala as $user): ?>
                        <option value="<?= $user['id_user']; ?>" <?= $user['id_user'] == $surat['user_id'] ? 'selected' : ''; ?>>
                            <?= $user['nama']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <a href="<?= site_url('operator/index'); ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update Surat</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
