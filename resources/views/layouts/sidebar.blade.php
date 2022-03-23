<aside class="main-sidebar sidebar-dark-blue elevation-4">
    <!-- Brand Logo -->
    {{-- <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets/dist/img/favicon-32x32.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bold">KANTOR KELURAHAN RONGGAKOE</span>
    </a> --}}

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mb-3 pb-3 d-block">
            <div class="image">
                <img src="{{ asset('assets/dist/img/logo.png') }}" alt="AdminLTE Logo" class="w-75 m-auto d-block">
            </div>
            <div class="info d-block">`
                <a href="#" class="d-block font-weight-bold text-center text-white">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    {{ Str::upper(session()->get('displayName')) }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Beranda
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('customer') }}"
                        class="nav-link {{ request()->is('customer') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            Customer
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('upcoming') }}"
                        class="nav-link {{ request()->is('upcoming') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-calendar"></i>
                        <p>
                            Upcoming Service
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('booking') }}"
                        class="nav-link {{ request()->is('booking') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-list"></i>
                        <p>
                            Booking Service
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#"
                        class="nav-link {{ request()->is('grafik/label_service') || request()->is('grafik/jumlah_service') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Grafik
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('grafik.label_service') }}"
                                class="nav-link {{ request()->is('grafik/label_service') ? 'active' : '' }}">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Label Service</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('grafik.jumlah_service') }}"
                                class="nav-link {{ request()->is('grafik/jumlah_service') ? 'active' : '' }}">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Jumlah Service</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('katalog') }}"
                        class="nav-link {{ request()->is('e-katalog') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-book"></i>
                        <p>
                            E-Katalog
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
