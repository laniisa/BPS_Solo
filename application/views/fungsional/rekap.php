<!DOCTYPE html>
<html lang="en">
<head>
    
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
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
<body>
<div class="content-wrapper">
  <?php if ($this->session->flashdata('message')) : ?>
    <?= $this->session->flashdata('message'); ?>
  <?php endif; ?>

  <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Rekapitulasi Surat</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
                </div>
            </div>
        </div>
    </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4>Filter Surat</h4>
            </div>
            <div class="card-body">
              <form id="filter-form" class="form">
                <div class="form-group mb-2">
                  <label for="tanggal_awal">Tanggal Awal</label>
                  <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control">
                </div>
                <div class="form-group mb-2">
                  <label for="tanggal_akhir">Tanggal Akhir</label>
                  <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control">
                </div>
                <div class="form-group mb-2">
                  <button type="submit" class="btn btn-primary">Tampilkan</button>
                  <button type="reset" class="btn btn-secondary ml-2" id="reset-button">Reset</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-12" id="surat-table-container">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead style="text-align: center;">
                    <tr>
                      <th>No</th>
                      <th>No Surat</th>
                      <th>Tgl Surat</th>
                      <th>Tgl Input</th>
                      <th>Tgl Dilaksanakan</th>
                      <th>Perihal</th>
                      <th>Asal</th>
                      <th>Jenis Surat</th>
                      <th>Status</th>
                    </tr>
                    </thead>
                    <tbody style="text-align: center;">
                      <?php $i = 1; ?>
                      <?php foreach ($surat as $item) : ?>
                        <tr>
                          <td><?= $i++; ?></td>
                          <td><?= $item['no_surat']; ?></td>
                          <td><?= $item['tgl_surat']; ?></td>
                          <td><?= $item['tgl_input']; ?></td>
                          <td><?= $item['tgl_dilaksanakan']; ?></td>
                          <td><?= $item['perihal']; ?></td>
                          <td><?= $item['asal']; ?></td>
                          <td><?= $item['jenis_surat']; ?></td>
                          <td><?= $item['status']; ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filter-form');
    const resetButton = document.getElementById('reset-button');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const tanggalAwal = document.getElementById('tanggal_awal').value;
        const tanggalAkhir = document.getElementById('tanggal_akhir').value;
        fetchSurat(tanggalAwal, tanggalAkhir);
    });

    resetButton.addEventListener('click', function() {
        fetchSurat('', '');
    });

    function fetchSurat(tanggalAwal, tanggalAkhir) {
        fetch(`<?= site_url('struktural/filter_rekap') ?>?tanggal_awal=${tanggalAwal}&tanggal_akhir=${tanggalAkhir}`)
            .then(response => response.json())
            .then(data => {
                renderTable(data);
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function renderTable(data) {
        const tableBody = document.querySelector('#example1 tbody');
        tableBody.innerHTML = '';
        data.forEach((item, index) => {
            const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.no_surat}</td>
                    <td>${item.tgl_surat}</td>
                    <td>${item.tgl_input}</td>
                    <td>${item.tgl_dilaksanakan}</td>
                    <td>${item.perihal}</td>
                    <td>${item.asal}</td>
                    <td>${item.jenis_surat}</td>
                    <td>${item.status}</td>
                    </td>
                </tr>`;
            tableBody.insertAdjacentHTML('beforeend', row);
        });
    }
});
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
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
