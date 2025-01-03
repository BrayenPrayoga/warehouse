<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a
            @if(Auth::guard('admin')->check())
                href="{{ route('admin.profil.index') }}"
            @elseif(Auth::guard('supervisor')->check())
                href="{{ route('supervisor.profil.index') }}"
            @else
                href="{{ route('user.profil.index') }}"
            @endif class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('assets/images/faces/person.jpg') }}" alt="profile">
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    @if(Auth::guard('admin')->check())
                        <span class="font-weight-bold mb-2">{{ Auth::guard('admin')->user()->name }}</span>
                    @elseif(Auth::guard('user_gate_in')->check())
                    <span class="font-weight-bold mb-2">{{ Auth::guard('user_gate_in')->user()->name }}</span>
                    @elseif(Auth::guard('user_gate_out')->check())
                    <span class="font-weight-bold mb-2">{{ Auth::guard('user_gate_out')->user()->name }}</span>
                    @elseif(Auth::guard('user_stok')->check())
                    <span class="font-weight-bold mb-2">{{ Auth::guard('user_stok')->user()->name }}</span>
                    @elseif(Auth::guard('user_billing')->check())
                    <span class="font-weight-bold mb-2">{{ Auth::guard('user_billing')->user()->name }}</span>
                    @elseif(Auth::guard('supervisor')->check())
                    <span class="font-weight-bold mb-2">{{ Auth::guard('supervisor')->user()->name }}</span>
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
            <li class="nav-item @if(Request::segment(1) == 'admin/users') active @endif">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <span class="menu-title">Users</span>
                    <i class="mdi mdi-account menu-icon"></i>
                </a>
            </li>
            <li class="nav-item @if(Request::segment(1) == 'admin/master-kategori') active @endif">
                <a class="nav-link" href="{{ route('admin.master-kategori.index') }}">
                    <span class="menu-title">Master Kategori</span>
                    <i class="mdi mdi-format-list-bulleted-type menu-icon"></i>
                </a>
            </li>
            <li class="nav-item @if(Request::segment(1) == 'admin/master-rak') active @endif">
                <a class="nav-link" href="{{ route('admin.master-rak.index') }}">
                    <span class="menu-title">Master Rak</span>
                    <i class="mdi mdi-grid menu-icon"></i>
                </a>
            </li>
            <li class="nav-item {{ (request()->is('admin/daftar-barang-masuk')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.daftar-barang-masuk.index') }}">
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
            <li class="nav-item {{ (request()->is('admin/masuk-rak')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.masuk-rak.index') }}">
                    <span class="menu-title">Masuk Rak</span>
                    <i class="mdi mdi-cube-send menu-icon"></i>
                </a>
            </li>
            <li class="nav-item @if(request()->is('admin/daftar-barang-keluar')) active @endif">
                <a class="nav-link" href="{{ route('admin.daftar-barang-keluar.index') }}">
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
            <li class="nav-item @if(request()->is('admin/sewa-barang')) active @endif">
                <a class="nav-link" href="{{ route('admin.sewa-barang.index') }}">
                    <span class="menu-title">Sewa Barang</span>
                    <i class="mdi mdi-cash-multiple menu-icon"></i>
                </a>
            </li>
        @endif
        @if(Auth::guard('user_gate_in')->check())
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
        @endif
        @if(Auth::guard('user_gate_out')->check())
            <li class="nav-item @if(Request::segment(1) == 'dashboard') active @endif">
                <a class="nav-link" href="{{ route('dashboard.index') }}">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>
            <li class="nav-item @if(request()->is('user/barang-keluar')) active @endif">
                <a class="nav-link" href="{{ route('user.barang-keluar.index') }}">
                    <span class="menu-title">Barang Keluar</span>
                    <i class="mdi mdi-cube-send menu-icon"></i>
                </a>
            </li>
        @endif
        @if(Auth::guard('user_stok')->check())
            <li class="nav-item @if(Request::segment(1) == 'dashboard') active @endif">
                <a class="nav-link" href="{{ route('dashboard.index') }}">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>
            <li class="nav-item {{ (request()->is('user/daftar-barang-masuk')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.daftar-barang-masuk.index') }}">
                    <span class="menu-title">Daftar Barang Masuk</span>
                    <i class="mdi mdi-cube-outline menu-icon"></i>
                </a>
            </li>
            <li class="nav-item @if(request()->is('user/daftar-barang-keluar')) active @endif">
                <a class="nav-link" href="{{ route('user.daftar-barang-keluar.index') }}">
                    <span class="menu-title">Daftar Barang Keluar</span>
                    <i class="mdi mdi-cube-outline menu-icon"></i>
                </a>
            </li>
        @endif
        @if(Auth::guard('user_billing')->check())
            <li class="nav-item @if(Request::segment(1) == 'dashboard') active @endif">
                <a class="nav-link" href="{{ route('dashboard.index') }}">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>
            <li class="nav-item @if(request()->is('user/sewa-barang')) active @endif">
                <a class="nav-link" href="{{ route('user.sewa-barang.index') }}">
                    <span class="menu-title">Sewa Barang</span>
                    <i class="mdi mdi-cash-multiple menu-icon"></i>
                </a>
            </li>
        @endif
        @if(Auth::guard('supervisor')->check())
            <li class="nav-item @if(Request::segment(1) == 'dashboard') active @endif">
                <a class="nav-link" href="{{ route('dashboard.index') }}">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>
            <li class="nav-item {{ (request()->is('supervisor/master-kategori')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('supervisor.master-kategori.index') }}">
                    <span class="menu-title">Master Kategori</span>
                    <i class="mdi mdi-format-list-bulleted-type menu-icon"></i>
                </a>
            </li>
            <li class="nav-item {{ (request()->is('supervisor/master-rak')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('supervisor.master-rak.index') }}">
                    <span class="menu-title">Master Rak</span>
                    <i class="mdi mdi-grid menu-icon"></i>
                </a>
            </li>
            <li class="nav-item {{ (request()->is('supervisor/daftar-barang-masuk')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('supervisor.daftar-barang-masuk.index') }}">
                    <span class="menu-title">Daftar Barang Masuk</span>
                    <i class="mdi mdi-cube-outline menu-icon"></i>
                </a>
            </li>
            <li class="nav-item {{ (request()->is('supervisor/barang-masuk')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('supervisor.barang-masuk.index') }}">
                    <span class="menu-title">Barang Masuk</span>
                    <i class="mdi mdi-cube-send menu-icon"></i>
                </a>
            </li>
            <li class="nav-item {{ (request()->is('supervisor/masuk-rak')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('supervisor.masuk-rak.index') }}">
                    <span class="menu-title">Masuk Rak</span>
                    <i class="mdi mdi-cube-send menu-icon"></i>
                </a>
            </li>
            <li class="nav-item @if(request()->is('supervisor/daftar-barang-keluar')) active @endif">
                <a class="nav-link" href="{{ route('supervisor.daftar-barang-keluar.index') }}">
                    <span class="menu-title">Daftar Barang Keluar</span>
                    <i class="mdi mdi-cube-outline menu-icon"></i>
                </a>
            </li>
            <li class="nav-item @if(request()->is('supervisor/barang-keluar')) active @endif">
                <a class="nav-link" href="{{ route('supervisor.barang-keluar.index') }}">
                    <span class="menu-title">Barang Keluar</span>
                    <i class="mdi mdi-cube-send menu-icon"></i>
                </a>
            </li>
            <li class="nav-item @if(request()->is('supervisor/sewa-barang')) active @endif">
                <a class="nav-link" href="{{ route('supervisor.sewa-barang.index') }}">
                    <span class="menu-title">Sewa Barang</span>
                    <i class="mdi mdi-cash-multiple menu-icon"></i>
                </a>
            </li>
        @endif
    </ul>
</nav>