@if(Request::ajax())
@yield('css')
@yield('content')
@yield('js')

@else

<?php
$mainmenu = $cp_menu;
$qmenu = app('request')->input('curr_menu');
//if(!$qmenu)$qmenu="Category";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description',Setting::getIfExists('site_desc'))">
    <meta name="keywords" content="@yield('keywords',Setting::getIfExists('site_key'))" />
    <meta name="author" content="@yield('author', 'MediaMisr')" />
    <title>Admin | @yield('title', 'cp')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('cp/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('cp/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Ionicons -->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('cp/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('cp/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('cp/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('cp/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('cp/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('cp/plugins/summernote/summernote-bs4.min.css')}}">

    <link href="{{ asset('cp/css/jquery.tag-editor.css') }}" rel="stylesheet">
    <!--<link href="{{ asset('cp/css/flaticon.css')}}" rel="stylesheet">-->
    <link href="{{ asset('cp/css/iziToast.min.css') }}" rel="stylesheet">
    <link href="{{ asset('cp/css/fontawesome-iconpicker.min.css')}}" rel="stylesheet" />

    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css" rel="stylesheet" />
    
    <!--<link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />-->
    
    
    <link href="{{ asset('cp/css/mystyle.css') }}" rel="stylesheet">

    @if(app()->getLocale()=='ar')
    <!-- Load Bootstrap RTL theme from RawGit -->
    <link rel="stylesheet" href="{{ asset('cp/css/bootstrap-rtl.min.css')}}">
    <!-- <link href="{{ asset('cp/css/adminlte-rtl.min.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('cp/css/custom-style.css') }}" rel="stylesheet">
    @endif

    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('cp/img/logo.png') }}" alt="{{Setting::getIfExists('site_name')}}" height="50" width="150">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('cp.dashboard')}}" class="nav-link">{{Setting::getIfExists('site_name')}}</a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav m{{(app()->getLocale()=='ar')?'r':'l'}}-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('cp.dashboard')}}" class="brand-link">
                <img src="{{asset('cp/img/favicon2.png')}}" alt="{{Setting::getIfExists('site_name')}}"
                class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{Setting::getIfExists('site_name')}}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="overflow:unset">
                    <div class="image">
                        @if(Auth::user()->mainImage())
                        <img src="{{ Auth::user()->mainImage() }}" class="img-circle elevation-2" alt="{{ Auth::user()->name }}">
                        @else
                        <img src="{{asset('cp/img/favicon2.png')}}" class="img-circle elevation-2" alt="{{ Auth::user()->name }}">
                        @endif
                    </div>
                    <div class="info" style="overflow:unset;z-endex:999">
                        {{--<a href="javascript:;" class="d-block">{{ Auth::user()->name }}</a>
                        --}}
                        <div class="dropdown">
                            <button class="btn btn-link text-white dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" id="logout-link" href="#">{{trans('app.logout')}}</a>
                                {!! Form::open(['route'=>['logout'],'method'=>'post','id'=>'logout-form'])!!}

                                {!! Form::close()!!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                                                                                                                  with font-awesome or any other icon font library -->
                        <li class="nav-item menu-open">
                            <a href="{{ route('cp.dashboard')}}" class="nav-link {{request()->is(app()->getLocale().'/dashboard')?'active':''}}">
                                <i class="nav-icon fas fa-tachometer-alt"></i> <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        @foreach($mainmenu as $key=>$menu)
                        {{-- @if(Auth::user()->hasRoles($menu['roles']))
                        --}}
                        @if(array_key_exists('childs',$menu))
                        <li class="nav-item" groups="{{implode(',',$menu['roles'])}}">
                            <a href="#" class="nav-link">
                                <i class="fa {{$menu['icon']}} nav-icon"></i>
                                <p>
                                    {{trans("cp.$key")}}
                                </p>
                                <i class="{{app()->getLocale()=='ar'?'left':'right'}} fas fa-angle-{{app()->getLocale()=='ar'?'left':'right'}}"></i>

                            </a>
                            <ul class="nav nav-treeview">

                                @foreach($menu['childs'] as $k=>$m)
                                {{-- @if(Auth::user()->hasRoles($m['roles']))
                                --}}
                                <li class="nav-item" groups="{{implode(',',$m['roles'])}}">
                                    <a href="{{rtrim($m['url'],'?')}}" class="nav-link">
                                        <i class="fa {{$m['icon']}} nav-icon"></i>
                                        <p>
                                            {{trans("cp.$k")}}
                                        </p>
                                    </a>
                                </li>
                                {{--@endif--}}
                                @endforeach


                            </ul>
                        </li>
                        @else
                        <li class="nav-item" groups="{{implode(',',$menu['roles'])}}">
                            <a href="{{rtrim($menu['url'],'?')}}" class="nav-link">
                                <i class="fa {{$menu['icon']}} nav-icon"></i>
                                <p>
                                    {{trans("cp.$key")}}
                                </p>
                            </a>
                        </li>
                        @endif
                        {{-- @endif--}}

                        @endforeach
                        {{--    <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('cp.dashboard')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i> <p>
                                        {{trans('app.dashboard')}}
                                    </p>
                                </a>
                            </li>--}}
                            {{--
                        </ul>
                    </li>
                    --}}
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <!-- <div class="container-fluid">
                                                      <div class="row mb-2">
                                                          <div class="col-sm-6"><h1 class="m-0">Dashboard</h1></div>
                                                          <div class="col-sm-6">
                                                          <ol class="breadcrumb float-sm-right">
                                                              <li class="breadcrumb-item"><a href="#">Home</a></li>
                                                              <li class="breadcrumb-item active">Dashboard v1</li>
                                                          </ol>
                                                          </div>
                                                      </div>
                                                      </div> -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<--<script src="{{ asset('cp/plugins/jquery/jquery.min.js')}}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="{{ asset('cp/js/jquery.form.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('cp/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('cp/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{ asset('cp/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ asset('cp/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{ asset('cp/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{ asset('cp/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('cp/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ asset('cp/plugins/moment/moment.min.js')}}"></script>
<script src="{{ asset('cp/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('cp/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{ asset('cp/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('cp/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('cp/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('cp/js/demo.js')}}"></script>

<script src="{{ asset('cp/js/ckfinder/ckeditor/ckeditor.js')}}"></script>
<script src="{{ asset('cp/js/ckfinder/ckfinder.js')}}"></script>
<script src="{{ asset('cp/js/jquery.tag-editor.min.js')}}"></script>
<script src="{{ asset('cp/js/iziToast.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('cp/js/fontawesome-iconpicker.min.js')}}"></script>

<!-- Validation Plugin Js -->
<script src="{{ asset('cp/plugins/jquery-validation/jquery.validate.js')}}"></script>

<!--<script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>-->

<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('cp/js/pages/dashboard.js')}}"></script>
<script src="{{ asset('cp/js/script.js')}}"></script>

<?php if (Session::has('response')) {
    $response = session()->pull('response');
    //dd($response);
} ?>
<script>
    $(function() {
        //$(".datepicker").datetimepicker();

        $('#logout-link').click(function() {
            $('#logout-form').submit();
        });
    });
</script>
@if(isset($response) && $response['type']=='success')
<script>
    $(function() {
        Success("{{$response['message']}}");
    });
</script>
@endif
@if(isset($response) && $response['type']=='error')
<script>
    $(function() {
        Error("{{$response['message']}}");
    });
</script>
@endif
@if($errors->any())
@php
$errMessage="";
foreach($errors->all() as $err) $errMessage.=$err."<br />";
@endphp
<script>
    $(function() {
        Error("{!!$errMessage!!}");
    });
</script>
@endif

@yield('js')
<script>
    $(function() {
        $(".nav a.nav-link").removeClass('active');
        $(".nav a.nav-link[href$='{{Request::getRequestUri()}}']").addClass('active').closest('.nav-treeview').addClass('menu-open').addClass('active');
    })
</script>

</body>
</html>

@endif