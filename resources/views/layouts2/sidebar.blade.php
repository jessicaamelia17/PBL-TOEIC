<style>
    .nav-sidebar .nav-item > .nav-link {
        color: white !important;
    }

    .nav-sidebar .nav-item > .nav-link.active {
        background-color: white !important;
        color: #3452F9 !important;
    }

    .nav-sidebar .nav-item > .nav-link.active i {
        color: #3452F9 !important;
    }

    .sidebar .form-inline .btn-sidebar i {
        color: white;
    }

    .nav-sidebar .nav-item > .nav-link.logout-link,
    .nav-sidebar .nav-item > .nav-link.logout-link p,
    .nav-sidebar .nav-item > .nav-link.logout-link i {
        color: #e3342f !important;
    }

    .nav-sidebar .nav-item > .nav-link.logout-link.active {
        background-color: #fff0f0 !important;
        color: #e3342f !important;
    }

    .sidebar-profile {
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        color: white;
    }

    .sidebar-profile img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid white;
    }

    .sidebar-profile .profile-info {
        flex-grow: 1;
    }

    .sidebar-profile .profile-info p {
        margin: 0;
        font-weight: 600;
        font-size: 16px;
    }

    .sidebar-profile .btn-edit-profile {
        background-color: #3452F9;
        color: white;
        padding: 5px 10px;
        font-size: 13px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .sidebar-profile .btn-edit-profile:hover {
        background-color: #2a43d6;
    }

    .sidebar-separator {
        border-bottom: 2px solid white;
        margin: 10px 0;
    }
</style>

<div class="sidebar">

    {{-- Profil Admin --}}
    <div class="sidebar-profile">
    <a href="{{ route('admin.profile') }}" style="display: flex; align-items: center; gap: 15px; color: white; text-decoration:none;">
        <img src="{{ asset('storage/foto_admin/' . auth('admin')->user()->foto) }}"
             alt="Foto Profil Admin"
             onerror="this.onerror=null;this.src='{{ asset('default-profile.png') }}';">
        <div class="profile-info">
            <p>{{ auth('admin')->user()->nama }}</p>
        </div>
    </a>
    <a href="{{ route('admin.profile.edit') }}" class="btn-edit-profile" title="Edit Profil Admin">
        <i class="fas fa-edit"></i> Edit Profile
    </a>
</div>


    <div class="sidebar-separator"></div>

    {{-- Sidebar Search Form --}}
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

    {{-- Sidebar Menu --}}
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
                <a href="{{ url('/admin/home') }}"
                   class="nav-link {{ (isset($activeMenu) && $activeMenu == 'dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.pendaftar.index') }}"
                   class="nav-link {{ (isset($activeMenu) && $activeMenu == 'pendaftar') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-check"></i>
                    <p>Data Pendaftaran</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.jadwal.index') }}"
                   class="nav-link {{ (isset($activeMenu) && $activeMenu == 'jadwal') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-calendar-alt"></i>
                    <p>Kelola Jadwal & Kuota</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.surat.index') }}"
                   class="nav-link {{ (isset($activeMenu) && $activeMenu == 'surat') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-envelope"></i>
                    <p>Surat Pengajuan</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.pengumuman.index') }}"
                   class="nav-link {{ (isset($activeMenu) && $activeMenu == 'pengumuman') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-upload"></i>
                    <p>Upload Pengumuman</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.hasil-ujian.index') }}"
                   class="nav-link {{ (isset($activeMenu) && $activeMenu == 'hasil-ujian') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Hasil Ujian</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.mahasiswa.index') }}"
                   class="nav-link {{ (isset($activeMenu) && $activeMenu == 'mahasiswa') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-graduate"></i>
                    <p>Data Mahasiswa</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.sertifikat.index') }}"
                   class="nav-link {{ (isset($activeMenu) && $activeMenu == 'sertifikat') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-certificate"></i>
                    <p>Pengambilan Sertifikat</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link logout-link"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
</div>
