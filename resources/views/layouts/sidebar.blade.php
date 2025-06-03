<aside class="main-sidebar sidebar-light-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column">
            <div class="info">
                @if(Auth::check())
                    <strong>{{ Auth::user()->level }}</strong><br>
                    {{ Auth::user()->departemen }}
                @endif
            </div>

            <div class="info mt-1">
                @if(Auth::check())
                    <span>{{ Auth::user()->name }}</span>
                @endif
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-header">MENU</li>
                    <li class="nav-item {{ request()->routeIs('dashboard-barang-keluar') ? 'menu-open' : '' }}">
                        <a href="{{ route('dashboard-barang-keluar') }}" class="nav-link {{ request()->routeIs('dashboard-barang-keluar') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Beranda
                                <i class="right fas"></i>
                            </p>
                        </a>
                    </li>

                    @if(Auth::check() && Auth::user()->level === 'Super Admin')
                        <li class="nav-item {{ request()->routeIs('kendaraan', 'approval', 'approval-dinas') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('kendaraan', 'approval', 'approval-dinas') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>
                                    Kelola Data
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                        
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('approval-dinas') }}" class="nav-link {{ request()->routeIs('approval-dinas') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-clipboard-list"></i>
                                        <p>Kelola Penggunaan Kendaraan Dinas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('approval') }}" class="nav-link {{ request()->routeIs('approval') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-clipboard-list"></i>
                                        <p>Kelola Pengeluaran Barang</p>
                                    </a>
                                </li>
                    
                                <li class="nav-item">
                                    <a href="{{ route('kendaraan') }}" class="nav-link {{ request()->routeIs('kendaraan') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-car-side"></i>
                                        <p>Kelola Kendaraan Dinas</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                
                    @if(Auth::check() && Auth::user()->level !== 'Security' && Auth::user()->level !== 'Super Admin')
                        <li class="nav-item {{ request()->routeIs('approval-dinas', 'approval') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('approval-dinas', 'approval') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>
                                    Kelola Persetujuan
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                        
                            <ul class="nav nav-treeview">
                                @if(
                                    Auth::check() && 
                                    !in_array(Auth::user()->level, ['Security']) &&
                                    !(Auth::user()->level === 'Ka.Sie' && Auth::user()->seksi !== 'GENERAL SERVICES')
                                )
                                    <li class="nav-item {{ request()->routeIs('approval-dinas') ? 'menu-open' : '' }}">
                                        <a href="{{ route('approval-dinas') }}" class="nav-link {{ request()->routeIs('approval-dinas') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-file-signature"></i>
                                            <p>
                                                Persetujuan Surat <br> Kendaraan Dinas
                                                <i class="right fas"></i>
                                            </p>                            
                                        </a>
                                    </li>
                                @endif
    
                            
                                @if(Auth::check() && !in_array(Auth::user()->level, ['Security']))
                                    <li class="nav-item">
                                        <a href="{{ route('approval') }}" class="nav-link {{ request()->routeIs('approval') ? 'active' : '' }}">
                                            <i class="fas fa-file-signature nav-icon"></i>
                                            <p>Persetujuan Surat <br> Barang Keluar</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if(Auth::check() && Auth::user()->level === 'Security')
                        <li class="nav-item {{ request()->routeIs('security') ? 'menu-open' : '' }}"> 
                            <a href="{{ route('security') }}" class="nav-link {{ request()->routeIs('security') ? 'active' : '' }}"> 
                        <i class="nav-icon fas fa-shield-alt"></i> 
                        <p>Scan QR-Code Persetujuan</p> </a> </li> 
                    @endif

                    <li class="nav-item" style="border-top: 1px solid #ccc; margin-top: 10px;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="#" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Keluar</p>
                            </a>
                        </form>
                    </li>

                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>


<!-- Sidebar Collapse Script -->
<script>
    $(document).ready(function() {
        // Mendapatkan URL saat ini
        var currentUrl = window.location.href;

        // Mengidentifikasi elemen sidebar yang sesuai dengan URL saat ini
        $('.nav-item').each(function() {
            var link = $(this).find('a').attr('href');
            
            // Memeriksa apakah URL saat ini cocok dengan link di sidebar
            if (currentUrl.includes(link)) {
                $(this).addClass('menu-open'); // Menambahkan kelas menu-open
                $(this).children('ul').css('display', 'block'); // Menampilkan sub-menu jika ada
            }
        });
    });
</script>