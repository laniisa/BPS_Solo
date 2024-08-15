<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/bootstrap/css/bootstrap.min.css'); ?>">
    <style>
        .table {
            table-layout: fixed; /* Memastikan kolom tabel memiliki lebar tetap */
        }
        .table th, .table td {
            vertical-align: middle;
            word-wrap: break-word; /* Memungkinkan kata untuk membungkus ke baris berikutnya */
            overflow-wrap: break-word; /* Menangani teks panjang yang meluas */
            max-width: 200px; /* Menentukan lebar maksimum untuk sel */
        }
        .btn {
            margin-top: 10px;
        }
        .table th {
            width: 20%; /* Menentukan lebar kolom header tabel */
        }
        .red-text {
            color: red;
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
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Detail Surat <?= isset($surat['no_surat']) ? $surat['no_surat'] : ''; ?></h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>No Disposisi</th>
                                            <td><?= isset($surat['no_disposisi']) ? $surat['no_disposisi'] : 'Tidak ada data'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>No Surat</th>
                                            <td><?= isset($surat['no_surat']) ? $surat['no_surat'] : 'Tidak ada data'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Surat</th>
                                            <td><?= isset($surat['tgl_surat']) ? $surat['tgl_surat'] : 'Tidak ada data'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Input</th>
                                            <td><?= isset($surat['tgl_input']) ? $surat['tgl_input'] : 'Tidak ada data'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Disposisi</th>
                                            <td><?= isset($surat['tgl_disposisi']) ? $surat['tgl_disposisi'] : 'Tidak ada data'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Dilaksanakan</th>
                                            <td><?= isset($surat['tgl_dilaksanakan']) ? $surat['tgl_dilaksanakan'] : 'Tidak ada data'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Perihal</th>
                                            <td><?= isset($surat['perihal']) ? $surat['perihal'] : 'Tidak ada data'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Asal</th>
                                            <td><?= isset($surat['asal']) ? $surat['asal'] : 'Tidak ada data'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Surat</th>
                                            <td><?= isset($surat['jenis_surat']) ? $surat['jenis_surat'] : 'Tidak ada data'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Berkas</th>
                                            <td>
                                                <?php if (isset($surat['berkas']) && $surat['berkas']): ?>
                                                    <a href="<?= base_url('uploads/' . $surat['berkas']); ?>" target="_blank" class="btn btn-primary">Lihat Berkas</a>
                                                <?php else: ?>
                                                    Tidak ada berkas
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Berkas Tambahan</th>
                                            <td>Tidak ada berkas tambahan</td>
                                        </tr>
                                        <tr>
                                            <th>Catatan Kepala</th>
                                            <td>
                                                <?php if (isset($kepala['catatan_kepala']) && $kepala['catatan_kepala']): ?>
                                                    <p><?= $kepala['catatan_kepala']; ?></p>
                                                <?php else: ?>
                                                    <p>Tidak ada catatan dari kepala.</p>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tindak Lanjut</th>
                                            <td>
                                                <?php if (isset($kepala['tindak_lanjut']) && $kepala['tindak_lanjut']): ?>
                                                    <p><?= $kepala['tindak_lanjut']; ?></p>
                                                <?php else: ?>
                                                    <p>Belum ada tindak lanjut.</p>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <a href="<?= site_url('struktural/kumpulan_surat'); ?>" class="btn btn-secondary">Kembali</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
