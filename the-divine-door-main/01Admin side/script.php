<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<!-- DataTables  & Plugins -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/jszip/jszip.min.js"></script>
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/moment/moment.min.js"></script>
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/dist/js/adminlte.js"></script>

<script>
  $(function () {
    $(document).on('click', '[data-bs-toggle="modal"]', function (e) {
      e.preventDefault();
      var target = $(this).attr('data-bs-target') || $(this).attr('href');
      if (target) {
        $(target).modal('show');
      }
    });

    $(document).on('click', '[data-bs-dismiss="modal"]', function () {
      $(this).closest('.modal').modal('hide');
    });

    if ($.fn.DataTable && $('#example1').length && !$.fn.dataTable.isDataTable('#example1')) {
      var example1 = $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false
      });

      if (typeof example1.buttons === 'function') {
        example1.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      }
    }

    if ($.fn.DataTable && $('#example2').length && !$.fn.dataTable.isDataTable('#example2')) {
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true
      });
    }
  });
</script>
