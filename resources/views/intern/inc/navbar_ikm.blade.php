<style>

  div.notifications-menu{
    width: 550px !important;
  }

  ul#on-mobile{
    display: none !important;
  }

  .badge-container{
    position: relative; 
    float: right; 
    margin-bottom: -24px; 
    z-index: 1; 
    margin-top: -10px
  }

  .bell-icon-container{
    position: relative; 
    font-size: 17pt; 
    margin-right: 10px; 
  }

  .badge-danger{
    background-color: red;
    color: #fff;
    font-size: 8pt
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

  @media only screen and (max-width:  700px){

    div.notifications-menu{
      width: 300px !important;
      padding: 20px
    }

    div.notifications-menu ul#main_notifications{
      display: none !important;
    }

    ul#on-mobile{
      display: block !important;
    }

  }
</style>

<div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="#" class="site_title"><span>@yield('barside.title', 'SKP Sumbawa Besar')</span></a>
    </div>
    <hr style="color: #eee; width: 100%" >
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <ul class="nav side-menu">
          <li>
            <a href="{{ route('intern.ikm.home.index') }}"><i class="fa fa-home"></i> Hasil Survey </a>
          </li>
          <li><a><i class="fa fa-line-chart"></i> Statistik <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('intern.ikm.statistik.index') }}" >Hasil Rekap IKM</a></li>
              <li><a href="{{ route('intern.ikm.grafik.index') }}" >Grafik & Statistik</a></li>
            </ul>
          </li>
          @if(superadmin() || admin())

            <li><a><i class="fa fa-gear"></i> Setting Aplikasi <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a href="{{ route('intern.ikm.settingikm.index') }}">Setting Jadwal</a></li>
                <li><a href="{{ route('intern.ikm.layanan.index') }}">Setting Layanan</a></li>
                <li><a href="{{ route('intern.ikm.question.index') }}">Setting Pertanyaan</a></li>
                <li><a href="{{ route('intern.ikm.answer.index') }}">Setting Jawaban</a></li>
                <li><a href="{{ route('intern.ikm.pendidikan.index') }}">Setting Pendidikan</a></li>
                <li><a href="{{ route('intern.ikm.pekerjaan.index') }}">Setting Pekerjaan</a></li>
                <li><a href="{{ route('intern.ikm.umur.index') }}">Setting Umur</a></li>
              </ul>
            </li>

          @endif
        </ul>
      </div>
    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
      <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
      </a>
    </div>
    <!-- /menu footer buttons -->
  </div>
</div>
<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="#" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            {{ ucwords(Auth::user()->pegawai->nama) }}&nbsp;&nbsp;&nbsp;
            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu pull-right">
            <li>
              <a href="{{ route('welcome') }}">
                <i class="fa fa-home pull-right"></i> Ke Halaman Utama
              </a>
            </li>
            <li>
              <a  href="{{ route('logout') }}"
                 onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  <i class="fa fa-sign-out pull-right"></i>Log Out
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a href="" id="btnNotifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div  class="badge-container">
              <span class="badge badge-pill badge-danger dropdown-count"></span>
            </div>
            <div  class="bell-icon-container">
              <i class="fa fa-bell"></i>
            </div>
          </a>
          <div class="dropdown-menu notifications-menu">
            <ul id="main_notifications" class="dropdown-item" role="menu" aria-hidden="true" style="list-style: none; background-color: #fff;"></ul>
            <ul id="on-mobile">
               <li>
                 <a href="{{ route('show.all.notifications') }}">Lihat semua pemberitahuan</a>
               </li>
            </ul>
          </div>
        </li>
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->


