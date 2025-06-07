<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <!-- Profile Icon -->
        <li class="nav-item d-flex align-items-center ms-2">
            <a class="nav-link p-0 d-flex align-items-center" href="{{ route('admin.profile') }}" title="Profil Admin"
                style="height: 34px;">
                @php
                    $admin = auth('admin')->user();
                @endphp
                @if ($admin && $admin->foto)
                    <img src="{{ asset('storage/foto_admin/' . $admin->foto) }}" alt="Profile"
                        class="rounded-circle border border-2" width="35" height="35" style="object-fit:cover;">
                @else
                    <img src="{{ asset('profile-picture.jpg') }}" alt="Profile" class="rounded-circle border border-2"
                        width="35" height="35" style="object-fit:cover;">
                @endif
            </a>
        </li>
    </ul>
</nav>
