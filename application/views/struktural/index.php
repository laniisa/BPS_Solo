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
            overflow-wrap: break-word;
            word-wrap: break-word;
            padding: 8px;
        }
        .card-header h1, .card-header h2 {
            margin-bottom: 0;
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
                                        <th>Asal</th>
                                        <th>Berkas</th>
                                        <th>Aksi</th>
                                        <th>Status</th>
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
                                    <td><?= $row['asal'] ?></td>
                                    <td>
                                        <?php if (!empty($row['berkas'])) : ?>
                                            <a href="<?= base_url('uploads/' . $row['berkas']) ?>" class="btn btn-warning btn-sm" target="_blank" style="color: white;">Lihat</a>
                                            <a href="<?= base_url('uploads/' . $row['berkas']) ?>" class="btn btn-danger btn-sm" download>Unduh</a>
                                        <?php else : ?>
                                            <span class="text-muted">Tidak ada berkas</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $this->db->select('COUNT(*) as action_click');
                                        $this->db->from('pegawai');
                                        $this->db->where('id_surat', $row['id_ds_surat']);
                                        $result = $this->db->get()->row_array();
                                        $action_click = $result['action_click'];

                                        if ($action_click >= 1) : ?>
                                            <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#userModal-<?= $row['id_ds_surat']; ?>">
                                                Detail Disposisi
                                            </a>
                                        <?php else : ?>
                                            <form action="<?= base_url('struktural/insert_pegawai') ?>" method="post">
                                                <input type="hidden" name="id_user" value="<?= $user['id_user']; ?>">
                                                <input type="hidden" name="no_surat" value="<?= $row['no_surat']; ?>">
                                                <select name="tindak_lanjut" class="form-control" <?= !empty($row['tindak_lanjut']) ? 'disabled' : '' ?> onchange="handleChange(this, <?= $row['id_ds_surat']; ?>)">
                                                    <option value="">Pilih Tindak Lanjut</option>
                                                    <option value="dilaksanakan" <?= isset($row['tindak_lanjut']) && $row['tindak_lanjut'] == 'dilaksanakan' ? 'selected' : '' ?>>Dilaksanakan</option>
                                                    <option value="diteruskan" <?= isset($row['tindak_lanjut']) && $row['tindak_lanjut'] == 'diteruskan' ? 'selected' : '' ?>>Diteruskan</option>
                                                </select>
                                            </form>
                                            <script>
                                            function handleChange(selectElement, suratId) {
                                                if (!selectElement.disabled) {
                                                    const userConfirmed = confirm("Aksi terhadap surat tidak akan bisa diubah. Apakah Anda yakin ingin memilih tindak lanjut?");
                                                    if (userConfirmed) {
                                                        selectElement.disabled = false;
                                                        selectElement.form.submit();  
                                                    } else {
                                                        selectElement.value = "";
                                                    }
                                                }
                                            }
                                        </script>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <?php
                                        if (isset($row['status']) && $row['status'] == 'diteruskan') {
                                            echo '<span class="text-muted">Diteruskan</span>';
                                        } else {
                                            echo '<span class="text-muted">Belum dilaksanakan</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <div class="modal fade" id="userModal-<?= $row['id_ds_surat']; ?>" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="userModalLabel">Detail Disposisi Surat</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                            <?php 
                                            $processed_users = []; 
                                            ?>

                                            <p>Telah mengambil tindakan:</p>
                                            <ul>
                                                <?php if (isset($catatan_pegawai_grouped[$row['id_ds_surat']])): ?>
                                                    <?php foreach ($catatan_pegawai_grouped[$row['id_ds_surat']] as $catatan): ?>
                                                        <li><?= $catatan['nama']; ?>: <?= $catatan['tindak_lanjut'] ?: 'Belum ada tindak lanjut'; ?></li>
                                                        <?php $processed_users[] = $catatan['nama']; ?>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <li>No users found</li>
                                                <?php endif; ?>
                                            </ul>

                                            <p>Belum mengambil tindakan:</p>
                                            <ul>
                                                <?php if (isset($tujuan_pegawai_grouped[$row['id_ds_surat']])): ?>
                                                    <?php foreach ($tujuan_pegawai_grouped[$row['id_ds_surat']] as $tujuan): ?>
                                                        <?php if (!in_array($tujuan['nama'], $processed_users)): ?>
                                                            <li><?= $tujuan['nama']; ?></li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <li>No users found</li>
                                                <?php endif; ?>
                                            </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "ordering": false,
    });
  });
</script>
</body>
</html>
