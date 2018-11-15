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
  
  <title>@yield('title', config('app.name'))</title>
  
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
  
  <link rel="icon" href="{{asset('images/favicon-32x32.png')}}" type="image/png" sizes="32x32">
  <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>

<body>
  <div class="body-wrapper">
    <!-- partial -->
    <!-- partial:../../partials/_navbar.html -->
    <header class="mdc-toolbar mdc-elevation--z4 mdc-toolbar--fixed">
      <div class="mdc-toolbar__row">
        <section class="mdc-toolbar__section mdc-toolbar__section--align-end" role="toolbar">
          <div class="mdc-menu-anchor mr-1" style="margin-right: 5% !important; color: #fff; cursor: pointer;">
              <a ref="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out fa-fw"></i> Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
        </section>
      </div>
    </header>
    <!-- partial -->

    <div class="col-md-12 mdc-toolbar-fixed-adjust">

      @yield('content')
  
    </div>

  </div>

  <!-- body wrapper -->
  <!-- plugins:js -->
  <script src="{{asset('js/material-components-web.min.js')}}"></script>
  <script src="{{asset('js/main.js')}}"></script>
  <!-- End custom js for this page-->
</body>

</html>