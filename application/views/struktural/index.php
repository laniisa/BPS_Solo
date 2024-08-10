<!DOCTYPE html>
<html lang="en">
<head>
    <title>Daftar Surat | <?= $title; ?></title>
    <!-- Other head elements -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #454d55;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="color: white;">Surat Terbaru</h1>
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
                    <div class="card" style="background-color: #343a40; color: white;">
                        <div class="card-header">
                            <a href="<?= base_url('admin/insert_op') ?>" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Tambah Admin</a>
                        </div>
                        <!-- /.card-header -->
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
                                        <th>Berkas</th>
                                        <th>Aksi</th>
                                        <th>Konfirmasi</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                    <?php $i = 1; ?>
                                    <?php foreach ($surat as $row) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $row['no_surat'] ?></td>
                                            <td><?= $row['tgl_surat'] ?></td>
                                            <td><?php if (!empty($row['berkas'])) : ?>
                                                <a href="<?= base_url('uploads/' . $row['berkas']) ?>" class="btn btn-info btn-sm" download>Unduh</a>
                                            <?php else : ?>
                                                <span class="text-muted">Tidak ada berkas</span>
                                            <?php endif; ?>
                                            </td>
                                            <td>
                                            <form action="<?= base_url('struktural/edit_tindakan/' . $row['id_ds_surat']); ?>" method="POST">
                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                            <select name="tindak_lanjut" class="form-control" onchange="this.form.submit()">
                                                <option value="dilaksanakan" <?= isset($row['tindak_lanjut']) && $row['tindak_lanjut'] == 'dilaksanakan' ? 'selected' : ''; ?>>Dilaksanakan</option>
                                                <option value="diteruskan" <?= isset($row['tindak_lanjut']) && $row['tindak_lanjut'] == 'diteruskan' ? 'selected' : ''; ?>>Diteruskan</option>
                                            </select>
                                        </form>

                                            </td>
                                            <td>
                                            <?php if (isset($row['tindak_lanjut'])): ?>
                                                    <?php if ($row['tindak_lanjut'] == 'dilaksanakan') : ?>
                                                        <button type="button" class="btn btn-success btn-sm">Dilaksanakan</button>
                                                    <?php elseif ($row['tindak_lanjut'] == 'diteruskan') : ?>
                                                        <button type="button" class="btn btn-danger btn-sm">Diteruskan</button>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <span class="text-muted">Status tidak tersedia</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot style="text-align: center;">
                                    <tr>
                                        <th>No</th>
                                        <th>No Surat</th>
                                        <th>Tgl Surat</th>
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
<!-- /.content-wrapper -->
</body>
</html>
