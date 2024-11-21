<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Profil Pengguna'; ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <style>
        /* Mengatur layout halaman */
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .content {
            min-height: calc(100vh - 100px); /* Menghitung tinggi konten untuk memberikan ruang bagi footer */
            padding: 20px 0;
        }

        /* Mengatur foto profil lebih besar dan responsif */
        .profile-photo {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
        }

        .default-avatar {
            width: 180px;
            height: 180px;
            background-color: #f0f0f0;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 50px;
            color: #bbb;
        }

        /* Menambahkan margin pada card dan isi konten */
        .card {
            margin-top: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            display: flex;
            align-items: center;
            padding: 30px;
        }

        .card-body img {
            margin-right: 20px;
        }

        .card-body h4 {
    margin-bottom: 15px;
    font-size: 24px;
    font-weight: 600;
    line-height: 1.5; /* Menambah jarak antar baris pada judul */
}

.card-body p {
    margin: 5px 0;
    font-size: 16px;
    line-height: 1.8; /* Menambah jarak antar baris pada paragraf */
}

        .card-body a {
            margin-top: 15px;
            font-size: 16px;
        }

        /* Styling untuk tombol Update Profil */
        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        /* Styling untuk card responsif */
        @media (max-width: 768px) {
            .card-body {
                flex-direction: column;
                align-items: flex-start;
                text-align: center;
            }

            .card-body img {
                margin-right: 0;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="container mt-5">
            <h2 class="text-center mb-4"><?= isset($title) ? $title : 'Profil Pengguna'; ?></h2>

            <div class="card mx-auto" style="max-width: 700px;">
                <div class="card-body">
                    <!-- Foto Profil -->
                    <div>
                        <?php if (!empty($user['foto']) && file_exists(FCPATH . 'assets/img/foto-users/' . $user['foto'])): ?>
                            <img src="<?= base_url('assets/img/foto-users/' . $user['foto']); ?>" alt="Foto Profil" class="profile-photo img-thumbnail">
                        <?php else: ?>
                            <div class="default-avatar">
                                <span>?</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Informasi Profil -->
                    <div>
                        <h4><?= isset($user['nama']) ? $user['nama'] : 'Nama Tidak Ditemukan'; ?></h4>
                        <p><strong>Email:</strong> <?= isset($user['email']) ? $user['email'] : '-'; ?></p>
                        <p><strong>WhatsApp:</strong> <?= isset($user['whatsApp']) ? $user['whatsApp'] : '-'; ?></p>
                        <p><strong>Jabatan:</strong> <?= isset($user['jabatan']) ? $user['jabatan'] : '-'; ?></p>
                        <a href="<?= base_url('admin/update_profile'); ?>" class="btn btn-primary">Update Profil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
