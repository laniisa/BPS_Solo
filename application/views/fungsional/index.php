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
                                            <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#userModal" data-no_surat="<?= $row['no_surat']; ?>">
                                                Detail Disposisi
                                            </a>
                                        <?php else : ?>
                                            <form action="<?= base_url('fungsional/insert_pegawai') ?>" method="post">
                                                <input type="hidden" name="id_user" value="<?= $user['id_user']; ?>">
                                                <input type="hidden" name="no_surat" value="<?= $row['no_surat']; ?>">
                                                <select name="tindak_lanjut" class="form-control" <?= !empty($row['tindak_lanjut']) ? 'disabled' : '' ?> onchange="this.form.submit()">
                                                    <option value="">Pilih Tindak Lanjut</option>
                                                    <option value="dilaksanakan" <?= isset($row['tindak_lanjut']) && $row['tindak_lanjut'] == 'dilaksanakan' ? 'selected' : '' ?>>Dilaksanakan</option>
                                                    <option value="diteruskan" <?= isset($row['tindak_lanjut']) && $row['tindak_lanjut'] == 'diteruskan' ? 'selected' : '' ?>>Diteruskan</option>
                                                </select>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                    <!-- Modal -->
                                    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="userModalLabel">Tujuan Surat</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <ul id="userList">
                                                       
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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
                                        <th>Status</th>
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
<script>
    // This will be executed when the modal is opened
    $('#userModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);  // Button that triggered the modal
        var no_surat = button.data('no_surat');  // Extract no_surat from the data attribute
        
        $.ajax({
            url: '<?= base_url('struktural/get_user_tujuan_modal') ?>/' + no_surat,
            method: 'GET',
            success: function(response) {
                var userList = $('#userList');
                userList.empty(); // Clear the list before adding new data
                // Parse the JSON response and populate the modal
                $.each(response, function(index, user_name) {
                    userList.append('<li>' + user_name + '</li>');
                });
            }
        });
    });
</script>


</body>
</html>
