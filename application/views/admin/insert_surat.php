<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Mengatur layout agar konten tidak tertutup sidebar */
        .container {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        /* Menyesuaikan lebar konten agar tidak tertutup oleh sidebar */
        .content-wrapper {
            display: flex;
            flex-direction: column;
            flex: 1;
            margin-left: 250px; /* Menyesuaikan dengan lebar sidebar */
            padding: 20px;
        }

        /* Mengatur layout form agar responsif */
        form {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Menambahkan ruang di bawah form */
        .form-group label {
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
        }

        .form-group input[type="file"] {
            padding: 10px 0;
        }

        /* Styling tombol */
        .btn-primary,
        .btn-secondary {
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4"><?= $title; ?></h2>
        <form action="<?= site_url('admin/save_surat'); ?>" method="post" enctype="multipart/form-data">
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
        </form>
    </div>
</body>
</html>
