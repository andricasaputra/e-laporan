<!--==========================
    Top Bar
  ============================-->
  <section id="topbar" class="d-none d-lg-block">
    <div class="container clearfix">
      <div class="contact-info float-left">
        <i class="fa fa-envelope-o"></i> <a href="mailto:contact@example.com">humasskpsumbawa@gmail.com</a>
        <i class="fa fa-phone"></i> (0371) 2629152
      </div>
      <div class="social-links float-right">
        <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
        <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
        <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
        <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
        <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
      </div>
    </div>
  </section>

  <!--==========================
    Header
  ============================-->
  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">

        <!-- Uncomment below if you prefer to use an image logo -->
         <a href="#body"><img src="{{ asset('images/brand.png') }}" alt="" title="" /></a>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu"><a href="{{ route('ikm.home') }}">Home</a></li>
          <li class="menu"><a href="{{ route('ikm.survey') }}">Survey</a></li>
          <li><a href="#contact">FAQ</a></li>
          <li><a href="#body">Web Sumbawa</a></li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->