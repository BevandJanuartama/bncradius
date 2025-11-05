<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="robots" content="noindex,nofollow">
  <meta name="google" content="notranslate">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>RADIUS INSTANCES</title>
  <link rel="shortcut icon" href="/assets/img/icon.png">

  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Daterangepicker -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
  <!-- iCheck Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">
  <!-- Tempus Dominus Bootstrap 4 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@5.39.0/dist/css/tempus-dominus.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
  <!-- OverlayScrollbars -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars/css/OverlayScrollbars.min.css">
  <!-- SweetAlert2 Bootstrap-4 Theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="/assets/css/custom.css">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed">

  <!-- Loading Spinner -->
  <div id="loading" class="d-none">
    <div class="load">
      <div class="spinner-border text-primary" style="width: 7rem; height: 7rem;" role="status">
        <span class="visually-hidden"></span>
      </div>
    </div>
  </div>

  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="https://api.whatsapp.com/send?phone=6282171032180" target="_blank" class="btn btn-success">
            <i class="fab fa-whatsapp fa-lg"></i> <b>Technical Support</b>
          </a>
        </li>
      </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <div class="brand-link">
        <span class="brand-text font-weight-light ml-2 font-weight-bold">RLCLOUD MANAGER</span>
      </div>

      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="/assets/img/avatar.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">Bepan</a>
          </div>
        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item"><a href="/instance" class="nav-link"><i class="nav-icon fas fa-microchip"></i><p>Instances</p></a></li>
            {{-- <li class="nav-item"><a href="/remote" class="nav-link"><i class="nav-icon fas fa-shield-alt"></i><p>Remote</p></a></li> --}}
            <li class="nav-item"><a href="/invoice" class="nav-link"><i class="nav-icon fas fa-file-alt"></i><p>Invoice</p></a></li>
            {{-- <li class="nav-item"><a href="https://www.youtube.com/playlist?list=PLVA91M9nFgiyTfSrQctnx2vBdnp7IRsYJ" target="_blank" class="nav-link"><i class="nav-icon fab fa-youtube"></i><p>Video Panduan</p></a></li> --}}
            {{-- <li class="nav-item"><a href="/jasasetting" class="nav-link"><i class="nav-icon fa fa-cog"></i><p>Jasa Setting</p></a></li> --}}
            {{-- <li class="nav-item"><a href="https://stats.uptimerobot.com/4VGvDtJpNX" target="_blank" class="nav-link"><i class="nav-icon fa fa-server"></i><p>Status Server</p></a></li> --}}
            {{-- <li class="nav-item"><a href="/faq" class="nav-link"><i class="nav-icon far fa-question-circle"></i><p>FAQ</p></a></li> --}}
            <li class="nav-item"><a href="/myaccount" class="nav-link"><i class="nav-icon fas fa-user-circle"></i><p>Account</p></a></li>
            <li class="nav-item"><a href="/auth/logout" class="nav-link"><i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p></a></li><form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="nav-link" style="background: none; border: none;">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
    </button>
</form>

          </ul>
        </nav>
      </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-12 col-sm-6 col-md-8 col-lg-8 col-xl-9 col-xxl-9">
                <h1>INI ISENG COBA COBaaaA</h1>
              <h2 class="text-bold">RADIUS INSTANCES</h2>
            </div>
          </div>
        </div>
      </section>

    <footer class="main-footer no-print text-white">
      &copy; 2020-2025 - <a href="https://rlradius.id" class="text-white">RLCLOUD MANAGER</a>
    </footer>
  </div>

  <!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>


<!-- PAGE PLUGINS -->
<!-- SweetAlert2 -->
<script src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="/assets/plugins/toastr/toastr.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- DataTables & Plugins -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

<!-- Bootstrap Duallistbox -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap4-duallistbox@4.0.2/dist/jquery.bootstrap-duallistbox.min.js"></script>

<!-- Moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<!-- Inputmask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>

<!-- Daterangepicker -->
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- JSZip (for DataTables export buttons) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- pdfmake (for DataTables export buttons) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

<!-- AdminLTE App -->
<script src="/assets/js/adminlte.js"></script>

<script>
const getDateTimeNow = "2025-07-29 13:29:08"
const getDateNow = "2025-07-29";
</script>



<script>

    const Toast = Swal.mixin({ toast: true,position: 'top-end',showConfirmButton: false,timer: 3000});
    
    // FUNCTION
        let tokenCSRF = null;
        // Format Rupiah
        function formatRupiah(angka) {
            let number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            if (ribuan) { separator = sisa ? '.' : ''; rupiah += separator + ribuan.join('.'); }
            if (angka < 0 ) return '-'+rupiah;
            return rupiah;
        }

        // Rupiah
        function rupiah(angka) {
            let number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            if (ribuan) { separator = sisa ? '.' : ''; rupiah += separator + ribuan.join('.'); }
            if (angka < 0 ) return 'Rp-'+rupiah;
            return 'Rp'+rupiah;
        }

        // 2021-12-30 23:59:01 to 30/12/2021 23:59:01
        function formatDateTime(data) { 
            if(data == null) return "-";
            let input = data.split(" ");
            let tanggal = input[0].split("-");
            let jam = input[1];
            return  tanggal[2] +'/'+tanggal[1]+'/'+tanggal[0] + ' ' + jam;
        }

        // 2021-12-30  to 30/12/2021
        function formatDate(data) { 
            if(data == null) return "-";
            let tanggal = data.split("-");
            return  tanggal[2] +'/'+tanggal[1]+'/'+tanggal[0];
        }

        // 30/12/2021 to 2021-12-30 
        function formatDbDate(data) { 
            if(data == null) return "-";
            let tanggal = data.split("/");
            return  tanggal[2] +'-'+tanggal[1]+'-'+tanggal[0];
        }

        // date compare
        function dateIsExpired(date) {
            if(date == null) return '-';
            if(new Date(getDateNow) > new Date(date)) return '<span class="text-danger font-weight-bold" >' + formatDate(date) + '</span>';
            return formatDate(date);
            }
        
        // date time compare
        function dateTimeIsExpired(datetime) {
            if(datetime == null) return '-';
            if(new Date(getDateTimeNow) > new Date(datetime)) return '<span class="text-danger font-weight-bold" >' + formatDateTime(datetime) + '</span>';
            return formatDateTime(datetime);
        }

        // date compare
        function IsExpired(date) {
            if(date == null) return false;
            if(new Date(getDateNow) > new Date(date)) return true;
            return false;
        }


        function setToken() {
            return true;

                // $.ajax({
                //     url: "/csrf",
                //     method: 'GET',
                //     dataType: 'json', 
                //     async : false,
                //     success: function (response) {
                //         tokenCSRF = response.token
                //         $(".tokenCSRF").remove();
                //         $("form").prepend('<input type="hidden" class="d-none tokenCSRF" name="_token" value="'+response.token+'">');   
                //     }
                // });

            }

        //setToken()

        function toTimeString(seconds) {
                return (new Date(seconds * 1000)).toUTCString().match(/(\d\d:\d\d:\d\d)/)[0];
                }
                
        // konversi byte
        function formatBytes(bytes) {
            if (bytes == 0 || bytes == null){
                return 0;
            } else {
        var s = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        var e = Math.floor(Math.log(bytes)/Math.log(1024));
        return (bytes/Math.pow(1024, Math.floor(e))).toFixed(2)+" "+s[e];
            }
        }

        // From Second
        function fromSeconds(a){
            if (a >= 31104000) {
            return Math.floor(a/60/60/24/30/12) + " tahun";
            } else if (a >= 2592000){
                return Math.floor(a/60/60/24/30) + " bulan";
            } else if (a >= 86400) {
                return Math.floor(a/60/60/24) + " hari";
            } else if (a >= 3600) {
                return Math.floor(a/60/60) + " jam";
            } else if (a >= 60) {
                return Math.floor(a/60) + " menit";
            } else {
                return Math.floor(a) + " detik";
            }
        }

        // replace space
        function replaceSpace(str){
            return str.replaceAll(/ /g,"")
        }

        // error select data
        function errorPilihData(){
            $(document).Toasts('create', { class: 'bg-danger',title: 'ERROR',body: 'Silahkan pilih data terlebih dahulu'});
            $(".toast-header").addClass('text-white');
        }
        // FUNCTION

</script>

</body>
</html>