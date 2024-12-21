<!DOCTYPE html>
<html lang="en">
<head>
   
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
                                            <th>Status</th>
                                            <td><?= $surat['status']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Detail Disposisi</th>
                                            <td>
                                                <?php if ($catatan_pegawai): ?>
                                                    <?php foreach ($catatan_pegawai as $catatan): ?>
                                                        <table class="info-table">
                                                            <tr>
                                                                <th>Nama:</th>
                                                                <td><?= $catatan['nama']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Catatan:</th>
                                                                <td><?= $catatan['catatan'] ? $catatan['catatan'] : 'Tidak ada catatan'; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tindak Lanjut:</th>
                                                                <td><?= $catatan['tindak_lanjut'] ? $catatan['tindak_lanjut'] : 'Belum ada tindak lanjut'; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tanggal:</th>
                                                                <td><?= $catatan['tanggal'] ? $catatan['tanggal'] : 'Belum ada tanggal'; ?></td>
                                                            </tr>
                                                        </table>
                                                        <hr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <p>Belum ada detail</p>
                                                <?php endif; ?>
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
