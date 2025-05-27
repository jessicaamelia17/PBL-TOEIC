<style>
    /* Warna teks default untuk semua link menu di sidebar */
    .nav-sidebar .nav-item > .nav-link {
        color: white !important;
    }

    /* Style untuk link menu yang aktif */
    .nav-sidebar .nav-item > .nav-link.active {
        background-color: white !important;
        /* Latar belakang putih saat aktif */
        color: #3452F9 !important;
        /* Warna teks biru saat aktif */
    }

    /* Style untuk ikon di dalam link menu yang aktif */
    .nav-sidebar .nav-item > .nav-link.active i {
        color: #3452F9 !important;
        /* Warna ikon biru saat aktif */
    }

    /* Style untuk ikon tombol search di sidebar */
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
                <button class="btn btn-sidebar" type="submit">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
                <a href="{{ url('/admin/home') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.pendaftar.index') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'pendaftar') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-check"></i>
                    <p>Data Pendaftaran</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.jadwal.index') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'jadwal') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-calendar-alt"></i>
                    <p>Kelola Jadwal & Kuota</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.surat.index') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'surat') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-envelope"></i>
                    <p>Surat Pengajuan</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.pengumuman.index') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'pengumuman') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-upload"></i>
                    <p>Upload Pengumuman</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.hasil-ujian.index') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'hasil-ujian') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Hasil Ujian</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.mahasiswa.index') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'mahasiswa') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Data Mahasiswa</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link text-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

        </ul>
    </nav>
</div>