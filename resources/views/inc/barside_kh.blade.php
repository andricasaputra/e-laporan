<div class="mdc-list-item mdc-drawer-item" data-toggle="expansionPanel" target-panel="ui-sub-menu-kh">
    <a class="mdc-drawer-link" href="#">
      <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">backup</i>
      Upload KH
      <i class="mdc-drawer-arrow material-icons">arrow_drop_down</i>
    </a>
    <div class="mdc-expansion-panel" id="ui-sub-menu-kh">
      <nav class="mdc-list mdc-drawer-submenu">
        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="{{ route('kh.upload.page.ekspor') }}">
            Ekspor
          </a>
        </div>
        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="{{ route('kh.upload.page.impor') }}">
            Impor
          </a>
        </div>
        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="{{ route('kh.upload.page.domas') }}">
            Domestik Masuk
          </a>
        </div>
        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="{{ route('kh.upload.page.dokel') }}">
            Domestik Keluar
          </a>
        </div>
      </nav>
    </div>
  </div>

  <div class="mdc-list-item mdc-drawer-item"  data-toggle="expansionPanel" target-panel="ui-sub-menu-kh-2">
    <a class="mdc-drawer-link" href="#">
      <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">dashboard</i>
      Download KH
      <i class="mdc-drawer-arrow material-icons">arrow_drop_down</i>
    </a>
    <div class="mdc-expansion-panel" id="ui-sub-menu-kh-2">
      <nav class="mdc-list mdc-drawer-submenu">
        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="{{ route('kh.download.page.ekspor') }}">
            Ekspor
          </a>
        </div>
        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="{{ route('kh.download.page.impor') }}">
            Impor
          </a>
        </div>
        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="{{ route('kh.download.page.domas') }}">
            Domestik Masuk
          </a>
        </div>
        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="{{ route('kh.download.page.dokel') }}">
            Domestik Keluar
          </a>
        </div>
      </nav>
    </div>
  </div>