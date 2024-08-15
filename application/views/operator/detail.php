<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/bootstrap/css/bootstrap.min.css'); ?>">
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .btn {
            margin-top: 10px;
        }
        .table th {
            width: 20%;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .info-table th, .info-table td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .info-table th {
            width: 30%;
        }
        .card-body > div {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Detail Surat</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= site_url('operator/') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Detail Surat</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Detail Surat</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>No Disposisi</th>
                                            <td><?= $surat['no_disposisi']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>No Surat</th>
                                            <td><?= $surat['no_surat']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Surat</th>
                                            <td><?= $surat['tgl_surat']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Input</th>
                                            <td><?= $surat['tgl_input']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Disposisi</th>
                                            <td><?= $surat['tgl_disposisi']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Dilaksanakan</th>
                                            <td><?= $surat['tgl_dilaksanakan']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Perihal</th>
                                            <td><?= $surat['perihal']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Asal</th>
                                            <td><?= $surat['asal']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Surat</th>
                                            <td><?= $surat['jenis_surat']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Catatan</th>
                                            <td>
                                                <div>
                                                    <h3>Catatan Kepala</h3>
                                                    <?php if ($catatan_kepala): ?>
                                                        <table class="info-table">
                                                            <tr>
                                                                <th>Nama:</th>
                                                                <td><?= $catatan_kepala['nama']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Catatan:</th>
                                                                <td><?= $catatan_kepala['catatan_kepala']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tindak Lanjut:</th>
                                                                <td><?= $catatan_kepala['tindak_lanjut']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tanggal:</th>
                                                                <td>
                                                                    <?php if ($catatan_kepala['tindak_lanjut'] == 'Diteruskan'): ?>
                                                                        <?= $catatan_kepala['tgl_disposisi']; ?>
                                                                    <?php else: ?>
                                                                        <?= $surat['tgl_dilaksanakan']; ?>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    <?php else: ?>
                                                        <p>Tidak ada catatan dari kepala.</p>
                                                    <?php endif; ?>

                                                    <h3>Catatan Pegawai</h3>
                                                    <?php if ($catatan_pegawai): ?>
                                                        <?php foreach ($catatan_pegawai as $catatan): ?>
                                                            <table class="info-table">
                                                                <tr>
                                                                    <th>Nama:</th>
                                                                    <td><?= $catatan['nama']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Catatan:</th>
                                                                    <td><?= $catatan['catatan']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Tindak Lanjut:</th>
                                                                    <td><?= $catatan['tindak_lanjut']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Tanggal:</th>
                                                                    <td>
                                                                        <?php if ($catatan['tindak_lanjut'] == 'Diteruskan'): ?>
                                                                            <?= $catatan['tanggal']; ?>
                                                                        <?php else: ?>
                                                                            <?= $surat['tgl_dilaksanakan']; ?>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <p>Tidak ada catatan dari pegawai.</p>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Berkas</th>
                                            <td>
                                                <?php if ($surat['berkas']) : ?>
                                                    <a href="<?= base_url('uploads/' . $surat['berkas']); ?>" target="_blank" class="btn btn-primary">Lihat Berkas</a>
                                                <?php else : ?>
                                                    Tidak ada berkas
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Berkas Tambahan</th>
                                            <td>Tidak ada berkas tambahan</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <a href="<?= site_url('operator/surat'); ?>" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
