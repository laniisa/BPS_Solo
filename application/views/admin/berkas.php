<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Rekapitulasi Lembar Disposisi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('admin/save_surat') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="<?= site_url('admin') ?>">Rekapitulasi Lembar Disposisi</a></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <a href="<?= base_url('admin/insert_surat') ?>" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Tambah Surat</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
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
                    <table class="table table-bordered table-striped" style="text-align: center;">
                        <thead style="text-align: center;">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Masuk</th>
                                <th>Dilaksanakan</th>
                                <th>Didisposisi</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
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
                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
