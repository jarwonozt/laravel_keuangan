<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Administrator - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('gambar/sistem/pavicon.png')}}">
    <link href="{{ asset('asset_admin/plugins/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset_admin/plugins/chartist/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset_admin/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') }}">
    <link href="{{ asset('asset_admin/plugins/toastr/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset_admin/css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('asset_admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset_admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset_admin/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">

</head>

<body>

    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>

    <div id="main-wrapper">

        <div class="nav-header bg-white text-center">
            <div class="brand-logo">
                <a href="{{ url('/home') }}">
                    <b class="logo-abbr"><img src="{{ asset('gambar/sistem/logo1.png')}}" alt=""> </b>
                    <span class="logo-compact"><img src="{{ asset('gambar/sistem/logo1.png') }}" alt=""></span>
                    <span class="brand-title">
                        <img src="{{ asset('gambar/sistem/logo1.png')}}" alt="" style="height: 30px"> 
                        <span class="text-white ml-2">LARA<b>DUIT</b></span>
                    </span>
                </a>
            </div>
        </div>

        <div class="header" style="background: transparent;">    
            <div class="header-content clearfix">

                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">

                </div>
                <div class="header-right">
                    <ul class="clearfix">

                        <li class="icons">
                            <div class="user-img c-pointer position-relative">
                                <span class="activity active"></span>
                                @if(Auth::user()->foto == "")
                                <img src="{{ asset('gambar/sistem/user.png')}}" height="40" width="40" alt="">
                                @else
                                <img src="{{ asset('gambar/user/'.Auth::user()->foto) }}" height="40" width="40">
                                @endif
                            </div>
                        </li>

                        <li class="icons dropdown d-none d-md-flex">
                            <a href="javascript:void(0)" class="log-user"  data-toggle="dropdown">
                                <span>{{ Auth::user()->name }}</span>  <i class="fa fa-angle-down f-s-14" aria-hidden="true"></i>
                            </a>
                            <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                          <span>{{ Auth::user()->name }}</span>
                                          <br> 
                                          <span class="text-muted">{{ Auth::user()->email }}</span>
                                      </li>

                                      <hr class="my-2">

                                      <li>
                                          <a href="{{ route('password') }}"><i class="icon-lock"></i> <span>Ganti Password</span></a>
                                      </li>
                                      <li>
                                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="icon-key"></i> <span>Logout</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>

    <div class="nk-sidebar">           

        <div class="p-3 profil_admin">
            <div class="media align-items-center mb-1 mt-3">
               @if(Auth::user()->foto == "")
               <img class="mr-2" src="{{ asset('gambar/sistem/user.png')}}" height="60" width="60" alt="">
               @else
               <img class="mr-2" src="{{ asset('gambar/user/'.Auth::user()->foto) }}" height="60" width="60">
               @endif
                <div class="media-body">
                    <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                    <p class="text-muted mb-0"><?php if(Auth::user()->level == "admin"){ echo "Administrator";}else{ echo "Bendahara"; } ?></p>
                </div>
            </div>
        </div>

        <div class="nk-nav-scroll">

            <ul class="metismenu" id="menu">

                <li class="nav-label">Dashboard</li>

                <li>
                    <a href="{{ route('home') }}" aria-expanded="false">
                        <i class="icon-speedometer menu-icon mr-3"></i><span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('kategori') }}" aria-expanded="false">
                        <i class="icon-grid menu-icon mr-3"></i><span class="nav-text">Data Kategori</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('transaksi') }}" aria-expanded="false">
                        <i class="icon-menu menu-icon mr-3"></i><span class="nav-text">Data Transaksi</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('laporan') }}" aria-expanded="false">
                        <i class="icon-notebook menu-icon mr-3"></i><span class="nav-text">Laporan</span>
                    </a>
                </li>

                @if(Auth::user()->level == "admin")

                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="icon-user menu-icon mr-3"></i><span class="nav-text">Pengguna</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('user') }}">Data Pengguna</a></li>
                        <li><a href="{{ route('user.tambah') }}">Tambah Pengguna Baru</a></li>
                    </ul>
                </li>
                @endif

                <li>
                    <a href="{{ route('password') }}" aria-expanded="false">
                        <i class="icon-lock menu-icon mr-3"></i><span class="nav-text">Ganti Password</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('logout') }}" aria-expanded="false" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="icon-logout menu-icon mr-3"></i><span class="nav-text">Log Out</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </div>
    </div>



    @yield('konten')




    <div class="footer">
        <div class="copyright">
            <p>Copyright &copy; Aplikasi Keuangan Menggunakan Laravel. by <a href="https://www.malasngoding.com" target="_blank">malasngoding.com</a> {{ date('Y') }}</p>
        </div>
    </div>
</div>



<div></div>


<script src="{{ asset('asset_admin/bower_components/jquery/dist/jquery.min.js') }}"></script>

<script src="{{ asset('asset_admin/plugins/common/common.min.js') }}"></script>
<script src="{{ asset('asset_admin/js/custom.min.js') }}"></script>
<script src="{{ asset('asset_admin/js/settings.js') }}"></script>
<script src="{{ asset('asset_admin/js/gleek.js') }}"></script>
<script src="{{ asset('asset_admin/js/styleSwitcher.js') }}"></script>

<script src="{{ asset('asset_admin/plugins/chart.js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/circle-progress/circle-progress.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/d3v3/index.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/topojson/topojson.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/pg-calendar/js/pignose.calendar.min.js') }}"></script>
<!-- <script src="{{ asset('asset_admin/plugins/chartist/js/chartist.min.js') }}"></script> -->
<!-- <script src="{{ asset('asset_admin/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js') }}"></script> -->

<script src="{{ asset('asset_admin/js/dashboard/dashboard-1.js') }}"></script>

<script src="{{ asset('asset_admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('asset_admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('asset_admin/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('asset_admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('asset_admin/bower_components/chart.js/Chart.min.js') }}"></script>

<script src="{{ asset('asset_admin/plugins/toastr/js/toastr.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/toastr/js/toastr.init.js') }}"></script>


@if(session('success'))
<script>
    toastr.success('{{session('success')}}');
</script>
@endif

<script>

    $(document).ready(function(){
        $('#table-datatable').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : false,
            'info'        : true,
            'autoWidth'   : true,
            "pageLength": 50
        });

        $('body').on('click', '.hamburger', function(){
            $(".profil_admin").toggle();
        });

    });

    $('#datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
    }).datepicker("setDate", new Date());

    $('.datepicker2').datepicker({
        autoclose: true,
        format: 'yyyy/mm/dd',
    });

</script>

</body>

</html>