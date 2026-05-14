<!-- ======= Header ======= -->
<style>
    .offcanvas-body .nav-link {
        font-weight: 500;
    }

    .offcanvas-body .nav-link:hover {
        color: #0d6efd;
    }

    .offcanvas.offcanvas-end {
        width: 75%;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .offcanvas-backdrop.show {
        background-color: rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(5px);
    }
</style>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top shadow-sm bg-white">
    <nav class="navbar navbar-expand-lg py-3">
        <div class="container">
            <!-- Logo -->
            <a href="{{ route('home.user') }}" class="navbar-brand d-flex align-items-center">
                <img 
                    src="{{ asset('img/logo/horizontal.svg') }}" 
                    alt="Logo"
                    class="img-fluid"
                    style="height: 60px; width: auto;"
                >
            </a>
            <!-- Toggle Mobile -->
            <button 
                class="navbar-toggler border-0 shadow-none"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#mobileNavbar"
            >
                <i class="bi bi-list fs-1"></i>
            </button>
            <!-- ================= DESKTOP NAVBAR ================= -->
            <div class="collapse navbar-collapse d-none d-lg-flex">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home.user') ? 'active text-primary fw-semibold' : '' }}" 
                        href="{{ route('home.user') }}">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('vehicles-list.index') ? 'active text-primary fw-semibold' : '' }}" 
                        href="{{ route('vehicles-list.index') }}">
                            Pilih Kendaraan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Daftar Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link shadow-sm rounded-3 px-3" href="#">
                            <i class="bi bi-question-circle me-1"></i>
                            Butuh Bantuan
                        </a>
                    </li>
                    <!-- Profile Desktop -->
                    <li class="nav-item dropdown pe-3">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                            <img 
                                src="{{ asset('nice/assets/img/profile-img.jpg') }}" 
                                alt="Profile" 
                                class="rounded-circle"
                                width="38"
                                height="38"
                            >
                            <span class="d-none d-md-block dropdown-toggle ps-2">
                                K. Anderson
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end profile">
                            <li class="dropdown-header">
                                <h6>Kevin Anderson</h6>
                                <span>Web Designer</span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <i class="bi bi-person"></i>
                                    <span class="ms-2">My Profile</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <i class="bi bi-gear"></i>
                                    <span class="ms-2">Account Settings</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a href="{{ route('logout') }}" class="dropdown-item d-flex align-items-center text-danger">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span class="ms-2">Sign Out</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!-- ================= MOBILE NAVBAR ================= -->
            <div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="mobileNavbar" >
                <!-- Header -->
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title fw-semibold">
                        Menu
                    </h5>
                    <button 
                        type="button" 
                        class="btn-close shadow-none"
                        data-bs-dismiss="offcanvas"
                    ></button>
                </div>
                <!-- Body -->
                <div class="offcanvas-body">
                    <!-- Profile Mobile -->
                    <div class="d-flex align-items-center mb-4">
                        <img 
                            src="{{ asset('nice/assets/img/profile-img.jpg') }}" 
                            alt="Profile"
                            class="rounded-circle me-3"
                            width="50"
                            height="50"
                        >
                        <div>
                            <h6 class="mb-0">Kevin Anderson</h6>
                            <small class="text-muted">
                                Web Designer
                            </small>
                        </div>
                    </div>
                    <!-- Menu Mobile -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link py-3 border-bottom {{ request()->routeIs('home.user') ? 'active text-primary fw-semibold' : '' }}" href="{{ route('home.user') }}">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-3 border-bottom {{ request()->routeIs('vehicles-list.index') ? 'active text-primary fw-semibold' : '' }}" href="{{ route('vehicles-list.index') }}">
                                Pilih Kendaraan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-3 border-bottom" href="#">
                                Daftar Pesanan
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a class="btn btn-light shadow-sm rounded-3 w-100 text-start" href="#">
                                <i class="bi bi-question-circle me-2"></i>
                                Butuh Bantuan
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link text-danger" href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>