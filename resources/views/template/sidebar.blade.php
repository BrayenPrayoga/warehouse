<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a @if(Auth::guard('user')->check()) href="{{ route('user.profil.index') }}" @else href="{{ route('admin.profil.index') }}" @endif class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('assets/images/faces/person.jpg') }}" alt="profile">
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    @if(Auth::guard('user')->check())
                    <span class="font-weight-bold mb-2">{{ Auth::guard('user')->user()->name }}</span>
                    @else
                    <span class="font-weight-bold mb-2">{{ Auth::guard('admin')->user()->name }}</span>
                    @endif
                    <span class="text-secondary text-small">Administrator</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        @if(Auth::guard('admin')->check())
            <li class="nav-item @if(Request::segment(1) == 'dashboard') active @endif">
                <a class="nav-link" href="{{ route('dashboard.index') }}">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>
            <li class="nav-item @if(Request::segment(1) == 'users') active @endif">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <span class="menu-title">Users</span>
                    <i class="mdi mdi-account menu-icon"></i>
                </a>
            </li>
            <li class="nav-item @if(Request::segment(1) == 'master-kategori') active @endif">
                <a class="nav-link" href="{{ route('master-kategori.index') }}">
                    <span class="menu-title">Master Kategori</span>
                    <i class="mdi mdi-format-list-bulleted-type menu-icon"></i>
                </a>
            </li>
            <li class="nav-item @if(Request::segment(1) == 'master-rak') active @endif">
                <a class="nav-link" href="{{ route('master-rak.index') }}">
                    <span class="menu-title">Master Rak</span>
                    <i class="mdi mdi-grid menu-icon"></i>
                </a>
            </li>
            <li class="nav-item {{ (request()->is('daftar-barang-masuk')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('daftar-barang-masuk.index') }}">
                    <span class="menu-title">Daftar Barang Masuk</span>
                    <i class="mdi mdi-cube-outline menu-icon"></i>
                </a>
            </li>
            <li class="nav-item {{ (request()->is('admin/barang-masuk')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.barang-masuk.index') }}">
                    <span class="menu-title">Barang Masuk</span>
                    <i class="mdi mdi-cube-send menu-icon"></i>
                </a>
            </li>
            <li class="nav-item @if(request()->is('daftar-barang-keluar')) active @endif">
                <a class="nav-link" href="{{ route('daftar-barang-keluar.index') }}">
                    <span class="menu-title">Daftar Barang Keluar</span>
                    <i class="mdi mdi-cube-outline menu-icon"></i>
                </a>
            </li>
            <li class="nav-item @if(request()->is('admin/barang-keluar')) active @endif">
                <a class="nav-link" href="{{ route('admin.barang-keluar.index') }}">
                    <span class="menu-title">Barang Keluar</span>
                    <i class="mdi mdi-cube-send menu-icon"></i>
                </a>
            </li>
        @endif
        @if(Auth::guard('user')->check())
            <li class="nav-item @if(Request::segment(1) == 'dashboard') active @endif">
                <a class="nav-link" href="{{ route('dashboard.index') }}">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>
            <li class="nav-item {{ (request()->is('user/barang-masuk')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.barang-masuk.index') }}">
                    <span class="menu-title">Barang Masuk</span>
                    <i class="mdi mdi-cube-send menu-icon"></i>
                </a>
            </li>
            <li class="nav-item @if(request()->is('user/barang-keluar')) active @endif">
                <a class="nav-link" href="{{ route('user.barang-keluar.index') }}">
                    <span class="menu-title">Barang Keluar</span>
                    <i class="mdi mdi-cube-send menu-icon"></i>
                </a>
            </li>
        @endif
    </ul>
</nav>