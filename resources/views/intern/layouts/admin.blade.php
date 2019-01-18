<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
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
  
    {{-- <link rel="manifest" href="{{ asset('manifest.json') }}"> --}}
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('images/web-sumbawa1x.png') }}">
    <link rel="apple-touch-icon" type="image/png" sizes="48x48" href="{{ asset('images/web-sumbawa1x.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/web-sumbawa2x.png') }}">
    <link rel="apple-touch-icon" type="image/png" sizes="96x96" href="{{ asset('images/web-sumbawa2x.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/web-sumbawa3x.png') }}">
    <link rel="apple-touch-icon" type="image/png" sizes="192x192" href="{{ asset('images/web-sumbawa3x.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/web-sumbawa4x.png') }}">
    <link rel="apple-touch-icon" type="image/png" sizes="512x512" href="{{ asset('images/web-sumbawa4x.png') }}">

    <title>@yield('title', 'Admin Panel Web Sumbawa')</title>

    <link rel="icon" type="image/png" href="{{asset('images/favicon-32x32.png')}}" sizes="32x32">

    <!-- Bootstrap -->
    <link href="{{asset('intern/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('intern/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('intern/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="{{asset('intern/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css')}}" rel="stylesheet"/>

    <link href="{{asset('intern/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('intern/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('intern/build/css/custom.min.css')}}" rel="stylesheet">

    @yield('custom-link')

    <style type="text/css">

        .alert-success:nth-of-type(1), .alert-danger:nth-of-type(1){
            margin-top: 5%;
        }

        #loader {
          position: fixed;
          z-index: 1000;
          top: 0;
          left: 0;
          height: 100%;
          width: 100%;
          background: rgba( 255, 255, 255, .8 ) 
                      url('../../../../images/preloader.gif') 
                      50% 50% 
                      no-repeat;
        }

        div#loader {
          overflow: hidden;   
          display: block;
        }

    </style>

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">

        @if(strpos(Route::current()->uri, 'intern/ikm/admin') !== false)

            @include('intern.inc.navbar_ikm')

        @else
            {{-- akan banyak else if --}}
            nothing

        @endif

        <!-- page content -->
        <div id="page-content" class="right_col" role="main">

            <div class="row">

              @include('intern.inc.message')

              @yield('content')

            </div>

        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            &copy; {{date('Y')}} | Stasiun Karatina Pertanian Kelas I Sumbawa Besar
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="{{asset('intern/vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('intern/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('intern/vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{asset('intern/vendors/nprogress/nprogress.js')}}"></script>
    <!-- jQuery custom content scroller -->
    <script src="{{asset('intern/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>

    <!-- Datatables -->
    <script src="{{asset('intern/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('intern/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

    
    <!-- Custom Theme Scripts -->
    <script src="{{asset('intern/build/js/custom.min.js')}}"></script>
    <script src="{{asset('intern/build/js/mywebadmin.js')}}"></script>

    <script src="{{ asset('js/pusher.min.js') }}"></script>

    @include('intern.inc.notifications_script')

    @yield('script')

    @yield('chart-script')

  </body>
</html>