<head>
  <link rel="stylesheet" href="<?= base_url('application\views\template_admin\css\footer.css'); ?>">
</head>
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Disposisi Surat BPS 
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <a href="https://surakartakota.bps.go.id/" style="color:#0279C8">Badan Pusat Statistik 2024</a>.</strong>
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
      "buttons": [
        {
          extend: "copy",
          exportOptions: {
            columns: ':visible'  // Hanya menyalin kolom yang terlihat
          }
        },
        {
          extend: "csv",
          exportOptions: {
            columns: ':visible'  // Hanya mengekspor kolom yang terlihat
          }
        },
        {
          extend: "excel",
          exportOptions: {
            columns: ':visible'  // Hanya mengekspor kolom yang terlihat
          }
        },
        {
          extend: "pdf",
          exportOptions: {
            columns: ':visible'  // Hanya mengekspor kolom yang terlihat
          }
        },
        {
          extend: "print",
          exportOptions: {
            columns: ':visible'  // Hanya mencetak kolom yang terlihat
          }
        },
        "colvis" // Tombol visibility untuk mengatur kolom mana yang akan ditampilkan
      ],
      "columnDefs": [
        // Tambahkan pengaturan visibilitas kolom jika diperlukan
        {
          targets: [0], // Misalnya, sembunyikan kolom pertama
          visible: true // Kolom pertama selalu terlihat
        },
        {
          targets: [1], // Misalnya, sembunyikan kolom kedua
          visible: false // Kolom kedua disembunyikan
        }
      ]
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