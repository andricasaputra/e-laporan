<aside class="mdc-persistent-drawer mdc-persistent-drawer--open" style="height: 100%">
  @auth
  <nav class="mdc-persistent-drawer__drawer" >
    <div class="mdc-persistent-drawer__toolbar-spacer">
      <a href="{{ route('intern.operasional.home') }}" class="brand-logo"><!--<img src="../../images/logo.svg" alt="logo">--></a>
    </div>
    <div class="mdc-list-group"> 
      <nav class="mdc-list mdc-drawer-menu">

        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="{{ route('intern.operasional.home') }}">
            <i class="fa fa-home fa-custom"></i>
            Home
          </a>
        </div>

        @if (Auth::user()->role->first()->id == 1 || Auth::user()->role->first()->id == 2)

          @include('intern.inc.barside_kt')
          @include('intern.inc.barside_kh')

        @elseif(Auth::user()->role->first()->id != 1 && Auth::user()->pegawai->jenis_karantina == 'kt')

          @include('intern.inc.barside_kt')

        @elseif(Auth::user()->role->first()->id != 1 && Auth::user()->pegawai->jenis_karantina == 'kh')

          @include('intern.inc.barside_kh')
          
        @endif

      </nav>
    </div>
  </nav>
  @endauth
</aside>