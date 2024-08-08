<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</head>
<body>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daftar Surat</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= site_url('operator') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" style="color: lightgrey;"><a href="<?= site_url('operator') ?>">Daftar Surat</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <?php if ($this->session->flashdata('message')) : ?>
            <?= $this->session->flashdata('message'); ?>
        <?php endif; ?>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
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
                                                    <a href="<?= base_url('operator/update_surat/' . $row['id_ds_surat']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="<?= base_url('operator/delete_surat/' . $row['id_ds_surat']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot style="text-align: center;">
                                        <tr>
                                            <th>No</th>
                                            <th>No surat</th>
                                            <th>Tgl Surat</th>
                                            <th>Tgl Input</th>
                                            <th>Perihal</th>
                                            <th>Asal</th>
                                            <th>Jenis Surat</th>
                                            <th>Berkas</th>
                                            <th>Tujuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
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
            }
        });
    }
    </script>
</body>
</html>
