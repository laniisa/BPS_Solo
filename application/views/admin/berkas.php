<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Lembar Disposisi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        .content-wrapper {
            flex: 1;
            background-color: #ffffff;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 10px 0;
            text-align: center;
            color: #6c757d;
            position: relative;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .info-box {
            background-color: #ffffff; /* Mengubah background color info-box menjadi putih */
            box-shadow: 0px 0px 30px rgba(127, 137, 161, 0.25);
            color: #333; /* Mengubah warna teks menjadi lebih gelap agar kontras dengan latar belakang putih */
            border-radius: 10px;
            padding: 15px;
        }
        .breadcrumb-item a {
            color: #007bff; /* Warna link breadcrumb */
        }
        .breadcrumb-item.active {
            color: #6c757d; /* Warna breadcrumb aktif */
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container mt-5">
        <h2>Rekapitulasi Lembar Disposisi</h2>
        <form method="get" action="">
            <div class="form-group row">
                <label for="bulan" class="col-sm-1 col-form-label">Bulan:</label>
                <div class="col-sm-2">
                    <input type="number" class="form-control" id="bulan" name="bulan" value="<?= $bulan ?>" min="1" max="12">
                </div>
                <label for="tahun" class="col-sm-1 col-form-label">Tahun:</label>
                <div class="col-sm-2">
                    <input type="number" class="form-control" id="tahun" name="tahun" value="<?= $tahun ?>" min="2000" max="<?= date('Y') ?>">
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                </div>
            </div>
        </form>
        
        <h4>Rekap Lembar Disposisi KF <?= $bulan ?> <?= $tahun ?></h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Masuk</th>
                    <th>Dilaksanakan</th>
                    <th>Didisposisi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($rekap) > 0): ?>
                    <?php foreach ($rekap as $index => $item): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $item['nama'] ?></td>
                            <td><?= $item['masuk'] ?></td>
                            <td><?= $item['dilaksanakan'] ?></td>
                            <td><?= $item['didisposisi'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
</body>
</html>
