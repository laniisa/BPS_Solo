<!DOCTYPE html>
<html lang="en">
<head>
    <title>Daftar Surat | <?= $title; ?></title>     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <style>
        .table th, .table td {
        vertical-align: middle;
        word-wrap: break-word; 
        overflow-wrap: break-word; 
        white-space: normal; 
        max-width: 0; 
    }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Surat Terbaru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- Breadcrumb -->
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-info">
            <?= $this->session->flashdata('message'); ?>
        </div>
    <?php endif; ?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if ($this->session->flashdata('success')) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?= $this->session->flashdata('success'); ?>
                                </div>
                            <?php endif; ?>

                            <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                                <thead style="text-align: center;">
                                    <tr>
                                        <th>No</th>
                                        <th>No Surat</th>
                                        <th>Tgl Surat</th>
                                        <th>Perihal</th>
                                        <th>Berkas</th>
                                        <th>Aksi</th>
                                        <th>Konfirmasi</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                <?php $i = 1; ?>
                                <?php foreach ($surat as $row) : ?>
                                <?php if ($row['status'] == 'dilaksanakan') {
                                    continue; 
                                } ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $row['no_surat'] ?></td>
                                    <td><?= $row['tgl_surat'] ?></td>
                                    <td><?= $row['perihal'] ?></td>
                                    <td>
                                        <?php if (!empty($row['berkas'])) : ?>
                                            <a href="<?= base_url('uploads/' . $row['berkas']) ?>" class="btn btn-warning btn-sm" target="_blank" style="color: white;">Lihat</a>
                                            <a href="<?= base_url('uploads/' . $row['berkas']) ?>" class="btn btn-danger btn-sm" download>Unduh</a>
                                        <?php else : ?>
                                            <span class="text-muted">Tidak ada berkas</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form action="<?= base_url('struktural/surat') ?>" method="get">
                                            <input type="hidden" name="user_id" value="<?= $user['id_user']; ?>">
                                            <input type="hidden" name="no_surat" value="<?= $row['no_surat']; ?>">
                                            <select name="tindak_lanjut" class="form-control" onchange="this.form.submit()">
                                                <option value="">Pilih Tindak Lanjut</option>
                                                <option value="dilaksanakan" <?= isset($row['tindak_lanjut']) && $row['tindak_lanjut'] == 'dilaksanakan' ? 'selected' : '' ?>>Dilaksanakan</option>
                                                <option value="diteruskan" <?= isset($row['tindak_lanjut']) && $row['tindak_lanjut'] == 'diteruskan' ? 'selected' : '' ?>>Diteruskan</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($row['tindak_lanjut']) && $row['tindak_lanjut'] == 'dilaksanakan') {
                                            echo '<span class="text-success">Dilaksanakan</span>';
                                        } elseif (isset($row['tindak_lanjut']) && $row['tindak_lanjut'] == 'diteruskan') {
                                            echo '<span class="text-danger">Diteruskan</span>';
                                        } else {
                                            echo '<span class="text-muted">Belum ada tindakan</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                                </tbody>
                                <tfoot style="text-align: center;">
                                    <tr>
                                        <th>No</th>
                                        <th>No Surat</th>
                                        <th>Tgl Surat</th>
                                        <th>Perihal</th>
                                        <th>Berkas</th>
                                        <th>Aksi</th>
                                        <th>Konfirmasi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
</body>
</html>
