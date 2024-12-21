<!DOCTYPE html>
<html lang="en">
<head>

    <title>Kumpulan Surat | <?= $title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/dist/css/adminlte.min.css">
    <style>
        .list-group-item {
            border: none; 
            padding: 15px 20px;
            margin-bottom: 10px; 
            border-radius: 8px; 
            background-color: #f8f9fa; 
        }

        .list-group-item a.font-weight-bold {
            font-size: 1.4rem;
            color: inherit; 
            text-decoration: none; 
            position: relative;
            display: block;
            max-width: 85%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }

        .list-group-item a.font-weight-bold:hover {
            text-decoration: none; 
            color: inherit;
            background-color: transparent 
        }
        body.dark-mode .list-group-item a.font-weight-bold:hover {
            color: inherit !important; 
            background-color: transparent !important; 
        }

        .btn-warning.btn-sm {
            padding: 5px 10px; 
        }

        small a {
            color: #ffffff; 
            background-color: #007bff; 
            padding: 0.01px 1.2px; 
            border-radius: 4px; 
            text-decoration: none; 
            font-size: 0.7rem; 
            display: inline-block; 
        }

        small a:hover {
            text-decoration: none; 
            color: #ffffff; 
            background-color: #007bff; 
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
                    <h1>Daftar Surat</h1>
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

                            <div class="input-group mb-3">
                                <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                            </div>

                            <?php if (empty($surat)) : ?>
                                <p class="text-center">Tidak ada surat untuk ditampilkan.</p>
                            <?php else : ?>
                                <ul class="list-group">
                                    <?php foreach ($surat as $row) : ?>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="<?= base_url('struktural/detail/' . $row['id_ds_surat']) ?>" class="font-weight-bold" title="Lihat Detail Surat">
                                                <?= $row['perihal'] ?>
                                            </a>
                                            <a href="<?= base_url('uploads/' . $row['berkas']) ?>" class="btn btn-warning btn-sm" download>
                                                <i class="fas fa-file-download"></i> Unduh
                                            </a>
                                        </div>
                                        <small class="text-muted">
                                            <a href="<?= base_url('uploads/' . $row['berkas']) ?>" target="_blank" title="Lihat Surat">
                                                <?= $row['asal'] ?>
                                            </a>
                                        </small>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <p id="noResult" class="text-center text-muted" style="display: none;">Tidak ada surat yang cocok dengan pencarian.</p>
                            <?php endif; ?>
                            
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

<script src="<?php echo base_url() ?>assets/admin/plugins/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $("#searchInput").on("keyup", function () {
            var value = $(this).val().toLowerCase(); 
            var visibleItems = 0;

            $(".list-group-item").filter(function () {
                var isVisible = $(this).text().toLowerCase().indexOf(value) > -1; 
                $(this).toggle(isVisible); 
                if (isVisible) visibleItems++;
            });

            $("#noResult").toggle(visibleItems === 0);
        });
    });
</script>
<script src="<?php echo base_url() ?>assets/admin/dist/js/adminlte.min.js"></script>
</body>
</html>
