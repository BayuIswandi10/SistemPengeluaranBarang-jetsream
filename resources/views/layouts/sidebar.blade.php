<ul class="navbar-nav bg-white sidebar sidebar-light accordion border" id="accordionSidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header px-3 py-2">
        <div class="sidebar-title text-gray-600 font-weight-bold">
            Yang Membawa
        </div>
        <div class="sidebar-user text-gray-800 small">
            @if(Auth::check())
                {{ Auth::user()->name }}
            @endif
        </div>
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Menu Section -->
    <div class="sidebar-menu">
        <!-- Nav Item - Dashboard -->
        <li class="nav-header">MENU</li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-home text-primary"></i>
                    <span class="text-gray-800">Dashboard</span>
                </a>
            </li>

            <!-- Nav Item - Data Persetujuan Barang -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('form') }}">
                    <i class="fas fa-clipboard-list text-gray-600"></i>
                    <span class="text-gray-800">Pengajuan Pengeluaran Barang</span>
                </a>
            </li>
        </li>

    </div>

    <!-- Divider -->
    <hr class="sidebar-divider mt-auto">

    <!-- Nav Item - Logout -->
    <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}" class="nav-link p-0">
            @csrf
            <button type="submit" class="btn btn-link nav-link text-gray-600">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>
</ul>
