<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
    @include('intern.inc.barside')
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
                  @if(Auth::user()->role_id == 1) 
                    <a href="{{ route('welcome.admin') }}">
                  @else
                    <a href="{{ route('welcome') }}">
                  @endif
                      
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