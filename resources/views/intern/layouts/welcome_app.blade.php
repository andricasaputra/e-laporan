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
  
{{--   <link rel="manifest" href="{{ asset('manifest.json') }}"> --}}
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
          <div class="mdc-menu-anchor dropdown-notifications">
            <a href="#" class="mdc-toolbar__icon toggle mdc-ripple-surface" data-toggle="dropdown" toggle-dropdown="notification-menu" data-mdc-auto-init="MDCRipple">
              <i class="material-icons">notifications</i>
              <span class="dropdown-count" data-count="0"></span>
            </a>
            <div class="mdc-simple-menu mdc-simple-menu--right" tabindex="-1" id="notification-menu">
              <ul class="mdc-simple-menu__items mdc-list" id="main_notifications" role="menu" aria-hidden="true">
                <li class="mdc-list-item" role="menuitem" tabindex="0">
                  Tidak ada pemberitahuan terbaru
                </li>
              </ul>
              <ul class="mdc-simple-menu__items mdc-list text-center" role="menu" aria-hidden="true">
                <li class="" role="menuitem" tabindex="0">
                  <a href="{{ route('show.all.notifications') }}" style="font-size: 10pt; color: #000">Lihat semua permberitahuan</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="mdc-menu-anchor mr-1">
            <a href="#" class="mdc-toolbar__icon toggle mdc-ripple-surface" data-toggle="dropdown" toggle-dropdown="logout-menu" data-mdc-auto-init="MDCRipple">
              <i class="material-icons">more_vert</i>
            </a>
            <div class="mdc-simple-menu mdc-simple-menu--right" tabindex="-1" id="logout-menu">
                <ul class="mdc-simple-menu__items mdc-list" role="menu" aria-hidden="true">
                  <li class="mdc-list-item" role="menuitem" tabindex="0">
                      <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out fa-fw"></i> Logout
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                  </li>
                </ul>
            </div>
          </div>
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
  <script src="{{asset('js/jquery.min.js')}}"></script>
  <script src="{{asset('js/material.js')}}"></script>
  {{-- <script src="{{asset('js/main.js')}}"></script> --}}
  <!-- End custom js for this page-->

  <script src="{{ asset('js/pusher.min.js') }}"></script>

  <script type="text/javascript">

      $('.mdc-toolbar__icon').click(function(){

        $('#main_notifications').load('{{route('map.notifications')}}')

      });

      $.ajax({

        url : '{{ route('api.notifications.perasional', $user->id) }}'

      }).done(function(response){

          $('.dropdown-count').html(response.length);

          let pusher = new Pusher('59c93649c71d44e27a0a', {
            cluster: 'ap1',
            encrypted: true
          });

          // Subscribe to the channel we specified in our Laravel Event
          let channel = pusher.subscribe('laporan-uploaded');

          // Bind a function to a Event (the full Laravel class)
          channel.bind('laporan-bulanan', function(data) {

            $('.dropdown-count').html(response.length + 1);
          
          });
        
      });
     
  </script>
</body>

</html>