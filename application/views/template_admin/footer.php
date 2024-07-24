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