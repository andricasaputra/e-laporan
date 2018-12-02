<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="e-Office-sumbawa" name="keywords">
    <meta content="e-Office-sumbawa" name="description">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="e-Office">
    <meta name="apple-mobile-web-app-title" content="e-Office">
    <meta name="theme-color" content="#00A9F4">
    <meta name="msapplication-navbutton-color" content="#00A9F4">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-starturl" content="/login">
  
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('images/web-sumbawa1x.png') }}">
    <link rel="apple-touch-icon" type="image/png" sizes="48x48" href="{{ asset('images/web-sumbawa1x.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/web-sumbawa2x.png') }}">
    <link rel="apple-touch-icon" type="image/png" sizes="96x96" href="{{ asset('images/web-sumbawa2x.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/web-sumbawa3x.png') }}">
    <link rel="apple-touch-icon" type="image/png" sizes="192x192" href="{{ asset('images/web-sumbawa3x.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/web-sumbawa4x.png') }}">
    <link rel="apple-touch-icon" type="image/png" sizes="512x512" href="{{ asset('images/web-sumbawa4x.png') }}">
  
    <title>@yield('title', config('app.name'))</title>
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">

    <style type="text/css">
        .user-pic{
          display: none;
        }

        @media only screen and (max-width: 765px){
          .user-pic{
            display: block;
          }
        }

        .badge-container{
          position: relative; 
          float: right; 
          margin-bottom: -24px; 
          z-index: 1; 
          margin-top: 10px
        }

        .bell-icon-container{
          position: relative; 
          font-size: 17pt; 
          color: #fff; 
          margin-right: 10px; 
          margin-top: 20px
        }

        #main_notifications{
          height: 800px;
          overflow-y: scroll;
        }

        /* width */
        #main_notifications::-webkit-scrollbar {
            width: 6px;
        }

        /* Track */
        #main_notifications::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
         
        /* Handle */
        #main_notifications::-webkit-scrollbar-thumb {
            background: #999999; 
            border-radius: 30px
        }

        /* Handle on hover */
        #main_notifications::-webkit-scrollbar-thumb:hover {
            background: #555; 
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
      <!-- Topbar header - style you can find in pages.scss -->
      <!-- ============================================================== -->
      <header class="topbar" data-navbarbg="skin5">
          <nav class="navbar top-navbar navbar-expand-md navbar-dark">
              <div class="navbar-header" data-logobg="skin5">
                  <!-- ============================================================== -->
                  <!-- Logo -->
                  <!-- ============================================================== -->
                  <a class="navbar-brand" href="index.html">
                      <!-- Logo icon -->
                      <b class="logo-icon">
                          <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                          <!-- Light Logo icon -->
                          <img src="{{ asset('images/web-sumbawa4x.png') }}" alt="homepage" width="45" class="light-logo" />
                      </b>
                      <!--End Logo icon -->
                      {{-- E-office Sumbawa --}}
                      <!-- Logo text -->
                      <span class="logo-text">

                      </span>
                  </a>
                  <!-- ============================================================== -->
                  <!-- End Logo -->
                  <!-- ============================================================== -->
                  <!-- This is for the sidebar toggle which is visible on mobile only -->
                  <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
              </div>
              <!-- ============================================================== -->
              <!-- End Logo -->
              <!-- ============================================================== -->
              <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                  <!-- ============================================================== -->
                  <!-- toggle and nav items -->
                  <!-- ============================================================== -->
                  <ul class="navbar-nav float-left mr-auto">
                  </ul>
                  <!-- ============================================================== -->
                  <!-- Right side toggle and nav items -->
                  <!-- ============================================================== -->
                  <ul class="navbar-nav float-right">
                      <!-- ============================================================== -->
                      <!-- User profile and search -->
                      <!-- ============================================================== -->
                      <li class="nav-item dropdown">
                        <a href="" id="btnNotifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <div  class="badge-container">
                            <span class="badge badge-pill badge-danger dropdown-count"></span>
                          </div>
                          <div  class="bell-icon-container">
                            <i class="fa fa-bell"></i>
                          </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated">
                          <ul id="main_notifications" class="dropdown-item" role="menu" aria-hidden="true" style="list-style: none; background-color: #fff;"></ul>
                        </div>
                      </li>
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('images/users/1.jpg') }}" alt="user" class="rounded-circle" width="31"></a>
                          <div class="dropdown-menu dropdown-menu-right user-dd animated">
                              <a class="dropdown-item" href="{{ route('welcome') }}"><i class="ti-home m-r-5 m-l-5"></i> Ke Halman Utama</a>
                              <a class="dropdown-item" href="javascript:void(0)"><i class="ti-user m-r-5 m-l-5"></i> My Profile</a>
                              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();"><i class="fa fa-sign-out-alt m-r-5 m-l-5"></i> Logout</a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  @csrf
                              </form>
                          </div>
                      </li>
                      <!-- ============================================================== -->
                      <!-- User profile and search -->
                      <!-- ============================================================== -->
                  </ul>
              </div>
          </nav>
      </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        @if(Auth::check())

          @if(Route::current()->getName() == 'users.index')

            @if(Auth::user()->role->first()->id === 1 || Auth::user()->role->first()->id === 2)

              @include('intern.inc.barside_manajemen')

            @endif
            
          @else

            @include('intern.inc.barside')

          @endif

        @endif
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-5">
                        <h4 class="page-title">Starter Page</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        @yield('content')
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                &copy;{{ date('Y') }} <br> Stasiun Karantina Pertanian Kelas I Sumbawa Besar
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
    <script src="{{ asset('js/popper.min.js') }}"></script>

    <script src="{{ asset('js/app-style-switcher.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('js/custom.js') }}"></script>

    <script src="{{ asset('js/datatables.min.js') }}"></script>

    <script src="{{ asset('js/datatables_operasional.js') }}"></script>

    <script src="{{ asset('js/pusher.min.js') }}"></script>

    @include('intern.inc.notifications_script')

    @yield('script')

</body>

</html>