<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body>
    <div class="content-wrapper">
        <!-- Notifikasi pesan -->
        <?php if ($this->session->flashdata('message')) : ?>
            <?= $this->session->flashdata('message'); ?>
        <?php endif; ?>

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tambah Surat</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= site_url('operator') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" style="color: lightgrey;"><a href="<?= site_url('operator') ?>"> Surat</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section>
    <div class="container-fluid">
        <div class="row">
            <!-- Jumlah Surat -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box" style="height: 120px; padding: 20px;">
                    <span class="info-box-icon bg-secondary elevation-1" style="font-size: 40px;"><i class="fas fa-user-friends"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text" style="font-size: 18px;">Jumlah Surat</span>
                        <span class="info-box-number" style="font-size: 24px;">
                            <?= $jumlah_surat ?> <small>surat</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- Surat Dilaksanakan -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3" style="height: 120px; padding: 20px;">
                    <span class="info-box-icon bg-success elevation-1" style="font-size: 40px;"><i class="fas fa-check-circle"></i></span> <!-- Ikon Ceklis -->
                    <div class="info-box-content">
                        <span class="info-box-text" style="font-size: 18px;">Surat Dilaksanakan</span>
                        <span class="info-box-number" style="font-size: 24px;">
                            <?= $surat_dilaksanakan; ?> <small>surat</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <!-- Surat Masuk -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3" style="height: 120px; padding: 20px;">
                    <span class="info-box-icon bg-primary elevation-1" style="font-size: 40px;"><i class="fas fa-envelope"></i></span> <!-- Ikon Surat Masuk -->
                    <div class="info-box-content">
                        <span class="info-box-text" style="font-size: 18px;">Surat Masuk</span>
                        <span class="info-box-number" style="font-size: 24px;">
                            <?= $surat_masuk; ?> <small>surat</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
    </div>
</section>


        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <h1>Tambah Surat</h1> <!-- Ganti warna teks menjadi hitam -->
                                    </div>
                                    <div class="col-sm-6">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="card-header">
                                <a href="<?= base_url('operator/insert_surat') ?>" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Tambah Surat</a>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                                    <thead style="text-align: center;">
                                        <tr>
                                            <th>No</th>
                                            <th>No Surat</th>
                                            <th>Tgl Surat</th>
                                            <th>Tgl Input</th>
                                            <th>Perihal</th>
                                            <th>Asal</th>
                                            <th>Jenis Surat</th>
                                            <th>Berkas</th>
                                            <th>Tujuan</th>
                                            <th>Konfirmasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center;">
                                        <?php $i = 1; ?>
                                        <?php foreach ($surat as $row) : ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $row['no_surat'] ?></td>
                                                <td><?= $row['tgl_surat'] ?></td>
                                                <td><?= $row['tgl_input'] ?></td>
                                                <td><?= $row['perihal'] ?></td>
                                                <td><?= $row['asal'] ?></td>
                                                <td><?= $row['jenis_surat'] ?></td>
                                                <td><?= $row['berkas'] ?> </td>
                                                <td>
                                                    <select name="tujuan" class="form-control" onchange="updateTujuan(<?= $row['id_ds_surat'] ?>, this.value)">
                                                        <option value="">Pilih Tujuan</option>
                                                        <?php foreach ($struktural_users as $user) : ?>
                                                            <option value="<?= $user['id_user'] ?>" <?= $row['user_id'] == $user['id_user'] ? 'selected' : ''; ?>><?= $user['nama'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Menampilkan nama pengguna berdasarkan user_id
                                                    $konfirmasi = 'Belum Dikonfirmasi';
                                                    foreach ($struktural_users as $user) {
                                                        if ($row['user_id'] == $user['id_user']) {
                                                            $konfirmasi = $user['nama'];
                                                            break;
                                                        }
                                                    }
                                                    echo $konfirmasi;
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('operator/update_surat/' . $row['id_ds_surat']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="<?= base_url('operator/delete_surat/' . $row['id_ds_surat']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
    function updateTujuan(id, value) {
        $.ajax({
            url: '<?= base_url('operator/update_tujuan') ?>',
            method: 'POST',
            data: { id_ds_surat: id, tujuan: value },
            success: function(response) {
                console.log(response);
                // Menampilkan konfirmasi update
                location.reload();
            }
        });
    }
    </script>
</body>
</html>
