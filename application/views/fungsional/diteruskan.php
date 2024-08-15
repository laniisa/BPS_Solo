<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('application\views\struktural\css\surat.css'); ?>">
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

        <?php if ($this->session->flashdata('message')) : ?>
            <div class="alert alert-info">
                <?= $this->session->flashdata('message'); ?>
            </div>
        <?php endif; ?>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><?= $surat['perihal']; ?></h3>
                            </div>
                            <div class="card-body">
                                <form action="<?= site_url('struktural/proses_tujuan'); ?>" method="post">
                                    <!-- Input hidden untuk no_disposisi -->
                                    <input type="hidden" name="no_surat" value="<?= $surat['no_surat']; ?>">
                                    <input type="hidden" name="tindak_lanjut" value="<?= $selected_tindak_lanjut; ?>">

                                    <table class="table table-bordered">
                                        <tbody>
                                        <?php if (!empty($surat)): ?>
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
                                                <th>Tindak Lanjut</th>
                                                <td><?= $surat['status']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Catatan</th>
                                                <td>
                                                    <input type="text" name="catatan_kepala" id="catatan_kepala" class="form-control" placeholder="Tuliskan catatan Anda di sini..." required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Tujuan</th>
                                                <td>
                                                    <?php foreach ($users_fungsional as $user): ?>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="tujuan[]" value="<?= $user['id_user']; ?>" id="tujuan_<?= $user['id_user']; ?>">
                                                            <label class="form-check-label" for="tujuan_<?= $user['id_user']; ?>"><?= $user['nama']; ?></label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="2">Data tidak ditemukan</td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>

                                    <a href="<?= site_url('fungsional'); ?>" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
