      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
       </div>

    <footer class="main-footer">
      <strong>&copy; MKP 2025 - UNIVERSITAS MUHAMMADIYAH BIMA.</strong>
      All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

  </div>
  <!-- ./wrapper -->


  <!-- jQuery -->
  <script src="<?= base_url('template/plugins/jquery/jquery.min.js') ?>"></script>
  <!-- DataTables  & Plugins -->
  <script src="<?= base_url('template/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= base_url('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
  <!-- SweetAlert2 -->
  <script src="<?= base_url('template/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('template/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('template/js/adminlte.min.js') ?>"></script>

  <?php if (session()->getFlashdata('alert')): ?>
    <script>
      let alert = <?= json_encode(session()->getFlashdata('alert')) ?>;
      Swal.fire({
        icon: alert[0], // success, error, info, warning, question
        title: alert[1],
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
      });
  <?php endif; ?>
  </script>
  <script>
  //Page specific script

 $(function () {
  // Inisialisasi DataTable untuk tabel dengan id example1
  $("#example1").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  // Inisialisasi DataTable untuk tabel dengan id example2
  $("#example2").DataTable({
    "paging": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true
  });
});

</script>

</body>
</html>
