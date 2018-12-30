<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li>
                    <!-- User Profile-->
                    <div class="user-profile d-flex no-block dropdown m-t-20">
                        <div class="user-pic">
                           <img src="{{ asset('images/users/1.jpg') }}" alt="user" class="rounded-circle" width="40">
                            <a href="{{ route('show.all.notifications') }}">
                                <span class="badge badge-pill badge-primary">1</span>
                            </a>
                        </div>
                        <div class="user-content hide-menu m-l-10">
                            <a href="javascript:void(0)" class="" id="Userdd" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h5 class="m-b-0 user-name font-medium">&nbsp;&nbsp; {{ Auth::user()->pegawai->nama }} &nbsp; <i class="fa fa-angle-down"></i></h5>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Userdd">
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-user m-r-5 m-l-5"></i> My Profile</a>    
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('welcome') }}"><i class="fa fa-arrow-left m-r-5 m-l-5"></i>   
                                    Ke Halaman Utama
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- End User Profile-->
                </li>
                <!-- User Profile-->
                <li class="sidebar-item"> 
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('show.operasional') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Ringkasan</span>
                    </a>
                </li>
                <li class="sidebar-item"> 
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('showmenu.operasional.kh') }}" aria-expanded="false"><i class="mdi mdi-paw"></i><span class="hide-menu">Operasional KH</span>
                    </a>
                </li>
                <li class="sidebar-item"> 
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('showmenu.operasional.kt') }}" aria-expanded="false"><i class="mdi mdi-leaf"></i><span class="hide-menu">Operasional KT</span>
                    </a>
                </li>
                <li class="sidebar-item"> 
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ asset('storage/e-operasional/guides-e-operasional.pdf') }}" aria-expanded="false" target="_blank" rel="noreferrer"><i class="mdi mdi-book-open-page-variant"></i><span class="hide-menu">Manual E - Operasional</span>
                    </a>
                </li>
            </ul>
            
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->

