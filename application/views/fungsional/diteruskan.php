<!DOCTYPE html>
<html lang="en">
<head>
    <title>Surat Diteruskan</title>     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Detail Surat Diteruskan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url('fungsional'); ?>">Daftar Surat</a></li>
                            <li class="breadcrumb-item active">Surat Diteruskan</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h5>Detail Surat</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>No Surat</th>
                                <td><?= $no_surat; ?></td>
                            </tr>
                            <tr>
                                <th>User ID</th>
                                <td><?= $user_id; ?></td>
                            </tr>
                            <!-- Tambahkan informasi lain yang diperlukan -->
                        </table>

                        <br>
                        <a href="<?= base_url('fungsional'); ?>" class="btn btn-primary">Kembali ke Daftar Surat</a>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
</body>
</html>
