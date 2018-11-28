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
              <li><a href="{{ route('intern.ikm.statistik.index') }}">Hasil Rekap IKM</a></li>
              <li><a href="{{ route('intern.ikm.grafik.index') }}">Grafik & Statistik</a></li>
            </ul>
          </li>
          @if(Auth::user()->role->first()->id == 1 || Auth::user()->role->first()->id == 2)

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
                <i class="fa fa-home pull-right"></i> Go To Home
              </a>
            </li>
            <li>
              <a  href="{{ route('logout') }}"
                 onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                  <i class="fa fa-sign-out pull-right"></i>Log Out
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </li>
          </ul>
        </li>

      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->


