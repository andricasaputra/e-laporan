<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>@yield('title', 'Survey Indeks Kepuasan Masyarakat')</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="{{asset('images/favicon-32x32.png')}}" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="{{asset('css/app.css')}}" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="{{asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/animate.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/ionicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/magnific-popup.css')}}" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="{{asset('css/reveal.css')}}" rel="stylesheet">

  @yield('link')

</head>

<body id="body">

  @yield('content')

  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>Reveal</strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a href="https://bootstrapmade.com/" target="_blank">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="{{asset('js/jquery.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('js/easing.min.js')}}"></script>
  <script src="{{asset('js/hoverIntent.js')}}"></script>
  <script src="{{asset('js/superfish.min.js')}}"></script>
  <script src="{{asset('js/wow.min.js')}}"></script>
  <script src="{{asset('js/owl.carousel.min.js')}}"></script>
  <script src="{{asset('js/magnific-popup.min.js')}}"></script>
  <script src="{{asset('js/sticky.js')}}"></script>

  <!-- Contact Form JavaScript File -->
  <script src="{{asset('js/contactform.js')}}"></script>

  <!-- Template Main Javascript File -->
  <script src="{{asset('js/reveal.js')}}"></script>

  @yield('script')

</body>
</html>