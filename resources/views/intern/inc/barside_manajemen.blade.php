<aside class="mdc-persistent-drawer mdc-persistent-drawer--open" style="height: 100%">
  @auth
  <nav class="mdc-persistent-drawer__drawer" >
    <div class="mdc-persistent-drawer__toolbar-spacer">
      <a href="{{ route('intern.operasional.home') }}" class="brand-logo"><!--<img src="../../images/logo.svg" alt="logo">--></a>
    </div>
    <div class="mdc-list-group"> 
      <nav class="mdc-list mdc-drawer-menu">

        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="{{ route('users.index') }}">
            <i class="fa fa-home fa-custom"></i>
            Home
          </a>
        </div>

        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="{{ route('register') }}">
            <i class="fa fa-gear fa-custom"></i>
            Register User
          </a>
        </div>
      </nav>
    </div>
  </nav>
  @endauth
</aside>