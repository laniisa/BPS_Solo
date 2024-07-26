<style>
  .main-footer {
  position: relative;
  height: 50px; /* Adjust height as needed */
}

.main-footer::before,
.main-footer::after,
.footer-middle {
  content: "";
  position: absolute;
  top: 0;
  height: 2px; /* Border height */
}

.main-footer::before {
  left: 0;
  width: 33.33%; /* First section width */
  background-color: #0F64A4; /* First color */
}

.footer-middle {
  left: 33.33%;
  width: 33.33%; /* Middle section width */
  background-color: #7DBD1A; /* Second color */
}

.main-footer::after {
  right: 0;
  width: 33.33%; /* Third section width */
  background-color: #E4891B; /* Third color */
}

.footer-content {
  position: relative;
  text-align: center;
  line-height: 50px; /* Match height for vertical centering */
  z-index: 1;
  background-color: #fff; /* Ensure text visibility */
}

.dataTables_wrapper .dataTables_filter input {
      background-color: #454d55; /* Background color for search input */
      border: 1px solid #ccc;
      padding: 6px 10px;
      border-radius: 4px;
      font-size: 14px;
      color: white;
    }
    /* Optional: Style for placeholder text */
    .dataTables_wrapper .dataTables_filter input::placeholder {
      color: #999;
    }
    /* Custom style for DataTables buttons */
    .dt-buttons {
      margin-top: 10px;
    }
  </style>
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Disposisi Surat BPS 
    </div>
    <!-- Default to the left -->
    <strong>Hak Cipta &copy; <a href="https://ft.unsoed.ac.id/" style="color:#00497D">Badan Pusat Statistik 2024</a>.</strong>
    <div class="footer-middle"></div>
  </footer>

  <!-- jQuery -->
<script src="<?= base_url('assets/admin') ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/admin') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets/admin') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/admin') ?>/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?= base_url('assets/admin') ?>/dist/js/demo.js"></script> -->
<!-- Page specific script -->
<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>

</html>