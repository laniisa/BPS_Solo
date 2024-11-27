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
        .list-group-item {
            border: none; /* Menghilangkan garis */
            padding: 15px 20px; /* Menambahkan padding untuk kenyamanan */
            margin-bottom: 10px; /* Menambahkan jarak antara item */
            border-radius: 8px; /* Menambahkan sedikit radius pada tepi */
            background-color: #f8f9fa; /* Menambahkan warna latar belakang */
        }
        .list-group-item a.font-weight-bold {
            font-size: 1.7rem; /* Membesarkan font untuk Perihal */
            color: #007bff; /* Warna biru untuk tautan */
            text-decoration: none; /* Menghapus underline */
            position: relative;
            display: block; /* Agar elemen bisa menampilkan teks di bawah */
            max-width: 85%; /* Agar teks tidak meluas ke samping */
            overflow: hidden; /* Menghilangkan teks yang meluas */
            text-overflow: ellipsis; /* Menampilkan ellipsis jika teks terlalu panjang */
            white-space: normal; /* Memungkinkan teks untuk membungkus ke baris berikutnya */
    
        }
        .list-group-item a.font-weight-bold:hover {
            text-decoration: underline; /* Menambahkan underline saat hover */
        }
        .list-group-item a.font-weight-bold::after {
            
            display: none; /* Awalnya disembunyikan */
            position: absolute;
            top: -25px;
            left: 0;
            background: rgba(0, 0, 0, 0.75);
            color: #fff;
            padding: 3px 5px;
            border-radius: 4px;
            white-space: nowrap;
            font-size: 0.875rem;
            z-index: 10;
        }
        
        .list-group-item small.text-muted::after {
            
            display: none; /* Awalnya disembunyikan */
            position: absolute;
            top: -25px;
            left: 0;
            background: rgba(0, 0, 0, 0.75);
            color: #fff;
            padding: 3px 5px;
            border-radius: 4px;
            white-space: nowrap;
            font-size: 0.875rem;
            z-index: 10;
        }
        .list-group-item small.text-muted:hover::after {
            display: block; /* Menampilkan tooltip saat hover */
        }
        .btn-warning.btn-sm {
            padding: 5px 10px; /* Menyesuaikan ukuran tombol */
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
                            <?php if ($this->session->flashdata('success')) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?= $this->session->flashdata('success'); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (empty($surat)) : ?>
                                <p class="text-center">Tidak ada surat untuk ditampilkan.</p>
                            <?php else : ?>
                                <ul class="list-group">
                                    <?php foreach ($surat as $row) : ?>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="<?= base_url('fungsional/detail/' . $row['id_ds_surat']) ?>" class="font-weight-bold" title="Lihat Detail Surat">
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
<script src="<?php echo base_url() ?>assets/admin/dist/js/adminlte.min.js"></script>
</body>
</html>
