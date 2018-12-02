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
   
  <link rel="icon" href="{{asset('images/favicon-32x32.png')}}" type="image/png" sizes="32x32">
  <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">

</head>

<body>
  <div class="body-wrapper">
    <!-- partial:../../partials/_sidebar.html -->
    @yield('barside')
    <!-- partial -->
    <!-- partial:../../partials/_navbar.html -->
    <header class="mdc-toolbar mdc-elevation--z4 mdc-toolbar--fixed">
      <div class="mdc-toolbar__row">
        <section class="mdc-toolbar__section mdc-toolbar__section--align-start">
          <a href="#" class="menu-toggler material-icons mdc-toolbar__menu-icon">menu</a>
        </section>
        <section class="mdc-toolbar__section mdc-toolbar__section--align-end" role="toolbar">
          <div class="mdc-menu-anchor mr-1">
            <a href="#" class="mdc-toolbar__icon toggle mdc-ripple-surface" data-toggle="dropdown" toggle-dropdown="logout-menu" data-mdc-auto-init="MDCRipple">
              <i class="material-icons">more_vert</i>
            </a>
            <div class="mdc-simple-menu mdc-simple-menu--right" tabindex="-1" id="logout-menu">
                <ul class="mdc-simple-menu__items mdc-list" role="menu" aria-hidden="true">

                  <a href="{{ route('welcome') }}">
                    <li class="mdc-list-item" role="menuitem" tabindex="0">
                      <i class="material-icons mdc-theme--primary mr-1">settings</i>
                      Go To Home
                    </li>
                  </a>
                  
                  <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <li class="mdc-list-item" role="menuitem" tabindex="0">
                      <i class="material-icons mdc-theme--primary mr-1">power_settings_new</i>Logout
                    </li>
                  </a>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
          </div>
        </section>
      </div>
    </header>
    <!-- partial -->

    <div class="page-wrapper mdc-toolbar-fixed-adjust">

      @yield('content')
  
    </div>

  </div>

  <!-- body wrapper -->

  <script src="{{asset('js/material-components-web.min.js')}}"></script>
  <script src="{{asset('js/jquery.min.js')}}"></script>
  <script src="{{asset('js/Chart.min.js')}}"></script>
  <script src="{{asset('js/progressbar.min.js')}}"></script>
  <script src="{{asset('js/misc.js')}}"></script>
  <script src="{{asset('js/material.js')}}"></script>
  <script src="{{asset('js/dashboard.js')}}"></script>
  <script src="{{asset('js/datatables.min.js')}}"></script>
  <script src="{{asset('js/datatables_operasional.js')}}"></script>
  
  @yield('script')

  <script>
    window.setTimeout(function() {
        $(".alert-success").fadeTo(500, 0).slideUp(500, function() {
            $(this).hide();
        });
    }, 5000);
  </script>
  <!-- End custom js for this page-->
</body>

</html>