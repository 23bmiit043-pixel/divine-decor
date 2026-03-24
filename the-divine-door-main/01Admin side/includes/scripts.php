<!-- jQuery -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/dist/js/adminlte.js"></script>
<!-- overlayScrollbars -->
<script src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- Common custom scripts -->
<script>
$(function () {
    // Sidebar active state
    var url = window.location;
    $('ul.nav-sidebar a').filter(function() {
        return this.href == url;
    }).addClass('active');
});
</script>
