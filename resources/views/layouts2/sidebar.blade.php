<style>
    .nav-sidebar .nav-item>.nav-link.active {
        background-color: white !important;
        color: #3452F9 !important;
    }

    .nav-sidebar .nav-item>.nav-link.active i {
        color: #3452F9 !important;
    }

    .sidebar .form-inline .btn-sidebar i {
        color: white;
    }
</style>
<div class="sidebar">
    <!-- Garis putih horizontal -->
    <div style="border-bottom: 2px solid white; margin: 10px 0;"></div>
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/admin') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/admin') }}" class="nav-link {{ $activeMenu == 'pendaftaran' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Data Pendaftaran</p>
                </a>
            </li>
        </ul>
    </nav>
</div>
