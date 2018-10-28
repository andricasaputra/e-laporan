<aside class="mdc-persistent-drawer mdc-persistent-drawer--open" style="height: 100%">
  @auth
  <nav class="mdc-persistent-drawer__drawer" >
    <div class="mdc-persistent-drawer__toolbar-spacer">
      <a href="{{ route('home') }}" class="brand-logo"><!--<img src="../../images/logo.svg" alt="logo">--></a>
    </div>
    <div class="mdc-list-group"> 
      <nav class="mdc-list mdc-drawer-menu">

        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="{{ route('home') }}">
            <i class="fa fa-home fa-custom"></i>
            Home
          </a>
        </div>

        @if (Auth::user()->role_id == 1 && Auth::user()->bagian == '-')

          @include('inc.barside_kt')
          @include('inc.barside_kh')

        @elseif(Auth::user()->role_id != 1 && Auth::user()->bagian == 'kt')

          @include('inc.barside_kt')

        @else

          @include('inc.barside_kh')
          
        @endif

         @if ( Auth::user()->role_id == 1 )
            @if (Route::has('register'))

                <div class="mdc-list-item mdc-drawer-item"  data-toggle="expansionPanel" target-panel="user-management">
                <a class="mdc-drawer-link" href="#">
                   <i class="fa fa-gear fa-custom" aria-hidden="true"></i>
                  User Management
                  <i class="mdc-drawer-arrow material-icons">arrow_drop_down</i>
                </a>
                <div class="mdc-expansion-panel" id="user-management">
                  <nav class="mdc-list mdc-drawer-submenu">
                    <div class="mdc-list-item mdc-drawer-item">
                      <a class="mdc-drawer-link" href="{{ route('users.show') }}">
                        Lihat Data
                      </a>
                    </div>
                    <div class="mdc-list-item mdc-drawer-item">
                      <a class="mdc-drawer-link" href="{{ route('register') }}">
                        Register New User
                      </a>
                    </div>
                  </nav>
                </div>
              </div>
              
            @endif
        @endif

      </nav>
    </div>
  </nav>
  @endauth
</aside>