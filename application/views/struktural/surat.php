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
                                <h3 class="card-title">Detail Surat</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <!-- Existing table rows -->
                                        <tr>
                                            <th>No Disposisi</th>
                                            <td><?= $surat['no_disposisi']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>No Surat</th>
                                            <td><?= $surat['no_surat']; ?></td>
                                        </tr>
                                        <!-- Other rows -->

                                        <!-- Display temporary data if available -->
                                        <?php if ($temp_data): ?>
                                            <tr>
                                                <th>Temporary User ID</th>
                                                <td><?= $temp_data['user_id']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Temporary Tindak Lanjut</th>
                                                <td><?= $temp_data['tindak_lanjut']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Temporary No Surat</th>
                                                <td><?= $temp_data['no_surat']; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>

                                <a href="<?= site_url(''); ?>" class="btn btn-secondary">Simpan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
