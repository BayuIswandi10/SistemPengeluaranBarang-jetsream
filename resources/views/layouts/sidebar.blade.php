<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    {{-- <a href="{{ url('Functions/Dashboard') }}" class="brand-link">
        <img src="{{ asset('assets/adminlte3.2/dist/img/Logo.png') }}" alt="Logo Politeknik Astra" class="brand-image">
        <span class="brand-text font-weight-light">Peminjaman Ruangan</span>
    </a> --}}


    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        
            <div class="info">
                @if(Auth::check())
                    {{ Auth::user()->name }}
                @endif
            </div>
        </div>
        
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-header">MENU</li>
                    <li class="nav-item {{ request()->routeIs('dashboard') ? 'menu-open' : '' }}">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Beranda
                                <i class="right fas"></i>
                            </p>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('form') ? 'menu-open' : '' }}">
                        <a href="{{ route('form') }}" class="nav-link {{ request()->routeIs('form') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>
                                Form Pengeluaran Barang
                                <i class="right fas"></i>
                            </p>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('approval') ? 'menu-open' : '' }}">
                        <a href="{{ route('approval') }}" class="nav-link {{ request()->routeIs('approval') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>
                                Data Persetujuan Barang Keluar
                                <i class="right fas"></i>
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="nav-link p-0">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link text-gray-600">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </li>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>