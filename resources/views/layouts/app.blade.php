<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="/upload/profil/{{ $profil->favicon }}" />

    <!-- Core Css -->
    <!-- <link rel="stylesheet" href="https://bootstrapdemos.adminmart.com/modernize/dist/assets/css/styles.css" /> -->
    <link id="themeColors" rel="stylesheet" href="{{ asset('template/back') }}/dist/css/styles.css" />

    <title>{{ $title }}</title>
    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="{{ asset('template/back') }}/dist/libs/owl.carousel/dist/assets/owl.carousel.min.css">

    <link rel="stylesheet" href="{{ asset('template/back') }}/dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">

    @stack('css')
</head>

<body>
    <!-- <div class="toast toast-onload align-items-center text-bg-primary border-0" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="toast-body hstack align-items-start gap-6">
            <i class="ti ti-alert-circle fs-6"></i>
            <div>
                <h5 class="text-white fs-3 mb-1">Welcome to Modernize</h5>
                <h6 class="text-white fs-2 mb-0">Easy to costomize the Template!!!</h6>
            </div>
            <button type="button" class="btn-close btn-close-white fs-2 m-0 ms-auto shadow-none" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div> -->
    <!-- Preloader -->
    <div class="preloader">
        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        <!-- Sidebar Start -->
        <aside class="left-sidebar with-vertical">
            <div><!-- ---------------------------------- -->
                <!-- Start Vertical Layout Sidebar -->
                <!-- ---------------------------------- -->
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="{{ asset('template/back') }}/../main/index.html" class="text-nowrap logo-img">
                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/logos/dark-logo.svg" class="dark-logo" alt="Logo-Dark" />
                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/logos/light-logo.svg" class="light-logo" alt="Logo-light" />
                    </a>
                    <a href="javascript:void(0)"
                        class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                        <i class="ti ti-x"></i>
                    </a>
                </div>

                <nav class="sidebar-nav scroll-sidebar" data-simplebar>
                    <ul id="sidebarnav">
                        @foreach ($menus->sortBy('position') as $menu) <!-- Mengurutkan menu_group berdasarkan posisi -->
                        @can($menu->permission_name) <!-- Memeriksa permission untuk grup menu -->
                        <!-- Section judul menu -->
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">{{ $menu->name }}</span>
                        </li>

                        @foreach ($menu->items->sortBy('position') as $item) <!-- Mengurutkan menu_items berdasarkan posisi -->
                        @can($item->permission_name) <!-- Memeriksa permission untuk item -->
                        @if(!empty($item->subItems)) <!-- Cek apakah menu memiliki submenu -->
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="{{ $item->icon }}"></i>
                                </span>
                                <span class="hide-menu">{{ $item->name }}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @foreach (collect($item->subItems)->sortBy('position') as $subItem) <!-- Mengurutkan subItems -->
                                @can($subItem->permission_name) <!-- Memeriksa permission untuk sub item -->
                                <li class="sidebar-item">
                                    <a href="{{ route($subItem->route) }}" class="sidebar-link">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">{{ $subItem->name }}</span>
                                    </a>
                                </li>
                                @endcan
                                @endforeach
                            </ul>
                        </li>
                        @else <!-- Jika tidak memiliki submenu -->
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs($item->route) ? 'active' : '' }}" href="{{ route($item->route) }}" aria-expanded="false">
                                <span>
                                    <i class="{{ $item->icon }}"></i>
                                </span>
                                <span class="hide-menu">{{ $item->name }}</span>
                            </a>
                        </li>
                        @endif
                        @endcan
                        @endforeach
                        @endcan
                        @endforeach
                    </ul>
                </nav>

                <!-- 


                <nav class="sidebar-nav scroll-sidebar" data-simplebar>
                    <ul id="sidebarnav">
                        @can('dashboard-list')
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Beranda</span>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/home" id="get-url" aria-expanded="false">
                                <span>
                                    <i class="ti ti-aperture"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        @endcan

                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Master</span>
                        </li>

                        @can('produk-list')
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/produk" aria-expanded="false">
                                <span>
                                    <i class="ti ti-app-window"></i>
                                </span>
                                <span class="hide-menu">Produk</span>
                            </a>
                        </li>
                        @endcan

                        @can('blog-list')
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-brand-blogger"></i>
                                </span>
                                <span class="hide-menu">Blog</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @can('kategori-blog-list')
                                <li class="sidebar-item">
                                    <a href="/kategori_blog" class="sidebar-link">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Kategori</span>
                                    </a>
                                </li>
                                @endcan

                                @can('blog-list')
                                <li class="sidebar-item">
                                    <a href="/blog" class="sidebar-link">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Berita</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan

                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Pengaturan</span>
                        </li>

                        @can('profil-edit')
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/profil/1/edit" aria-expanded="false">
                                <span>
                                    <i class="ti ti-user-circle"></i>
                                </span>
                                <span class="hide-menu">Profil Umum</span>
                            </a>
                        </li>
                        @endcan

                        @can('user-list')
                        <li class="sidebar-item {{ Request::is('users*') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Request::is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-user"></i>
                                </span>
                                <span class="hide-menu">User</span>
                            </a>
                        </li>
                        @endcan

                        @can('role-list')
                        <li class="sidebar-item {{ Request::is('roles*') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Request::is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-grid"></i>
                                </span>
                                <span class="hide-menu">Role</span>
                            </a>
                        </li>
                        @endcan

                        @can('permission-list')
                        <li class="sidebar-item {{ Request::is('permission*') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Request::is('permission*') ? 'active' : '' }}" href="{{ route('permission.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-menu"></i>
                                </span>
                                <span class="hide-menu">Permission</span>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </nav> -->






                <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
                    <div class="hstack gap-3">
                        <div class="john-img">
                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-1.jpg" class="rounded-circle" width="40" height="40"
                                alt="modernize-img" />
                        </div>
                        <div class="john-title">
                            <h6 class="mb-0 fs-4 fw-semibold">{{ explode(' ', Auth::user()->name)[0] }}</h6>

                            <span class="fs-2">{{ Auth::user()->getRoleNames()->first() }}</span>
                        </div>
                        <!-- Tombol Logout -->
                        <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button"
                            aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ti ti-power fs-6"></i>
                        </button>

                        <!-- Link dan Form Logout -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                    </div>
                </div>


            </div>
        </aside>



        <!--  Sidebar End -->
        <div class="page-wrapper">
            <!--  Header Start -->
            <header class="topbar">
                <div class="with-vertical"><!-- ---------------------------------- -->
                    <!-- Start Vertical Layout Header -->
                    <!-- ---------------------------------- -->
                    <nav class="navbar navbar-expand-lg p-0">
                        <ul class="navbar-nav">
                            <li class="nav-item nav-icon-hover-bg rounded-circle ms-n2">
                                <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                                    <i class="ti ti-menu-2"></i>
                                </a>
                            </li>
                            <li class="nav-item nav-icon-hover-bg rounded-circle d-none d-lg-flex">
                                <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class="ti ti-search"></i>
                                </a>
                            </li>
                        </ul>

                        <ul class="navbar-nav quick-links d-none d-lg-flex align-items-center">
                            <li class="nav-item dropdown-hover d-none d-lg-block">
                                <a class="nav-link" href="{{ asset('template/back') }}/main/app-calendar.html">Kalender</a>
                            </li>
                            <li class="nav-item dropdown-hover d-none d-lg-block">
                                <a class="nav-link" href="{{ asset('template/back') }}/main/app-email.html">Halaman Depan</a>
                            </li>
                        </ul>

                        <div class="d-block d-lg-none py-4">
                            <a href="{{ asset('template/back') }}/../main/index.html" class="text-nowrap logo-img">
                                <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/logos/dark-logo.svg" class="dark-logo" alt="Logo-Dark" />
                                <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/logos/light-logo.svg" class="light-logo" alt="Logo-light" />
                            </a>
                        </div>
                        <a class="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0"
                            href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="ti ti-dots fs-7"></i>
                        </a>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="javascript:void(0)"
                                    class="nav-link nav-icon-hover-bg rounded-circle mx-0 ms-n1 d-flex d-lg-none align-items-center justify-content-center"
                                    type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                                    aria-controls="offcanvasWithBothOptions">
                                    <i class="ti ti-align-justified fs-7"></i>
                                </a>
                                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                                    <!-- ------------------------------- -->
                                    <!-- start language Dropdown -->
                                    <!-- ------------------------------- -->
                                    <li class="nav-item nav-icon-hover-bg rounded-circle">
                                        <a class="nav-link moon dark-layout" href="javascript:void(0)">
                                            <i class="ti ti-moon moon"></i>
                                        </a>
                                        <a class="nav-link sun light-layout" href="javascript:void(0)">
                                            <i class="ti ti-sun sun"></i>
                                        </a>
                                    </li>


                                    <!-- ------------------------------- -->
                                    <!-- start notification Dropdown -->
                                    <!-- ------------------------------- -->
                                    <li class="nav-item nav-icon-hover-bg rounded-circle dropdown">
                                        <a class="nav-link position-relative" href="javascript:void(0)" id="drop2"
                                            aria-expanded="false">
                                            <i class="ti ti-bell-ringing"></i>
                                            <div class="notification bg-primary rounded-circle"></div>
                                        </a>
                                        <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                            aria-labelledby="drop2">
                                            <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                                <h5 class="mb-0 fs-5 fw-semibold">Notifikasi</h5>
                                                <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">5
                                                    new</span>
                                            </div>
                                            <div class="message-body" data-simplebar>
                                                <a href="javascript:void(0)"
                                                    class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                    <span class="me-3">
                                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-2.jpg" alt="user"
                                                            class="rounded-circle" width="48" height="48" />
                                                    </span>
                                                    <div class="w-100">
                                                        <h6 class="mb-1 fw-semibold lh-base">Roman Joined the Team!</h6>
                                                        <span class="fs-2 d-block text-body-secondary">Congratulate
                                                            him</span>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                    <span class="me-3">
                                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-3.jpg" alt="user"
                                                            class="rounded-circle" width="48" height="48" />
                                                    </span>
                                                    <div class="w-100">
                                                        <h6 class="mb-1 fw-semibold lh-base">New message</h6>
                                                        <span class="fs-2 d-block text-body-secondary">Salma sent you
                                                            new message</span>
                                                    </div>
                                                </a>

                                            </div>
                                            <div class="py-6 px-7 mb-1">
                                                <button class="btn btn-outline-primary w-100">Lihat Semua Notifikasi</button>
                                            </div>
                                        </div>
                                    </li>


                                    <!-- ------------------------------- -->
                                    <!-- start profile Dropdown -->
                                    <!-- ------------------------------- -->
                                    <li class="nav-item dropdown">
                                        <a class="nav-link pe-0" href="javascript:void(0)" id="drop1"
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <div class="user-profile-img">
                                                    <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-1.jpg"
                                                        class="rounded-circle" width="35" height="35"
                                                        alt="modernize-img" />
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                            aria-labelledby="drop1">
                                            <div class="profile-dropdown position-relative" data-simplebar>
                                                <div class="py-3 px-7 pb-0">
                                                    <h5 class="mb-0 fs-5 fw-semibold">Profil Pengguna</h5>
                                                </div>
                                                <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                                    <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-1.jpg"
                                                        class="rounded-circle" width="80" height="80"
                                                        alt="modernize-img" />
                                                    <div class="ms-3">
                                                        <h5 class="mb-1 fs-3">{{ Auth::user()->name }}</h5>
                                                        <span class="mb-1 d-block">{{ Auth::user()->getRoleNames()->first() }}</span>
                                                        <p class="mb-0 d-flex align-items-center gap-2" style="font-size: 10px;">
                                                            <i class="ti ti-mail fs-4"></i> {{ Auth::user()->email }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="message-body">
                                                    <a href="{{ asset('template/back') }}/../main/page-user-profile.html"
                                                        class="py-8 px-7 mt-8 d-flex align-items-center">
                                                        <span
                                                            class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-account.svg"
                                                                alt="modernize-img" width="24" height="24" />
                                                        </span>
                                                        <div class="w-100 ps-3">
                                                            <h6 class="mb-1 fs-3 fw-semibold lh-base">Profil</h6>
                                                            <span class="fs-2 d-block text-body-secondary">Pengaturan Profil</span>
                                                        </div>
                                                    </a>
                                                    <a href="{{ asset('template/back') }}/../main/app-notes.html"
                                                        class="py-8 px-7 d-flex align-items-center">
                                                        <span
                                                            class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-tasks.svg"
                                                                alt="modernize-img" width="24" height="24" />
                                                        </span>
                                                        <div class="w-100 ps-3">
                                                            <h6 class="mb-1 fs-3 fw-semibold lh-base">My Task</h6>
                                                            <span class="fs-2 d-block text-body-secondary">To-do and
                                                                Daily Tasks</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="d-grid py-4 px-7 pt-8">
                                                    <button class="btn btn-outline-primary" tabindex="0" type="button"
                                                        aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout"
                                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout
                                                        <i class="ti ti-power fs-3"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- ------------------------------- -->
                                    <!-- end profile Dropdown -->
                                    <!-- ------------------------------- -->
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <!-- ---------------------------------- -->
                    <!-- End Vertical Layout Header -->
                    <!-- ---------------------------------- -->

                    <!-- ------------------------------- -->
                    <!-- apps Dropdown in Small screen -->
                    <!-- ------------------------------- -->







                    <!--  Mobilenavbar -->
                    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="mobilenavbar"
                        aria-labelledby="offcanvasWithBothOptionsLabel">
                        <nav class="sidebar-nav scroll-sidebar">
                            <div class="offcanvas-header justify-content-between">
                                <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/logos/favicon.ico" alt="modernize-img" class="img-fluid" />
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body h-n80" data-simplebar="" data-simplebar>
                                <ul id="sidebarnav">
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="{{ asset('template/back') }}/../main/app-calendar.html" aria-expanded="false">
                                            <span>
                                                <i class="ti ti-calendar"></i>
                                            </span>
                                            <span class="hide-menu">Kalendar</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="{{ asset('template/back') }}/../main/app-email.html" aria-expanded="false">
                                            <span>
                                                <i class="ti ti-mail"></i>
                                            </span>
                                            <span class="hide-menu">Halaman Depan</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="app-header with-horizontal">
                    <nav class="navbar navbar-expand-xl container-fluid p-0">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item nav-icon-hover-bg rounded-circle d-flex d-xl-none ms-n2">
                                <a class="nav-link sidebartoggler" id="sidebarCollapse" href="javascript:void(0)">
                                    <i class="ti ti-menu-2"></i>
                                </a>
                            </li>
                            <li class="nav-item d-none d-xl-block">
                                <a href="{{ asset('template/back') }}/../main/index.html" class="text-nowrap nav-link">
                                    <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/logos/dark-logo.svg" class="dark-logo" width="180"
                                        alt="modernize-img" />
                                    <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/logos/light-logo.svg" class="light-logo" width="180"
                                        alt="modernize-img" />
                                </a>
                            </li>
                            <li class="nav-item nav-icon-hover-bg rounded-circle d-none d-xl-flex">
                                <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class="ti ti-search"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav quick-links d-none d-xl-flex align-items-center">
                            <!-- ------------------------------- -->
                            <!-- start apps Dropdown -->
                            <!-- ------------------------------- -->
                            <li class="nav-item nav-icon-hover-bg rounded w-auto dropdown d-none d-lg-flex">
                                <div class="hover-dd">
                                    <a class="nav-link" href="javascript:void(0)">
                                        Apps<span class="mt-1">
                                            <i class="ti ti-chevron-down fs-3"></i>
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-nav dropdown-menu-animate-up py-0">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="ps-7 pt-7">
                                                    <div class="border-bottom">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="position-relative">
                                                                    <a href="{{ asset('template/back') }}/../main/app-chat.html"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-dd-chat.svg"
                                                                                alt="modernize-img" class="img-fluid"
                                                                                width="24" height="24" />
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-1 fw-semibold fs-3">
                                                                                Chat Application
                                                                            </h6>
                                                                            <span
                                                                                class="fs-2 d-block text-body-secondary">New
                                                                                messages arrived</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="{{ asset('template/back') }}/../main/app-invoice.html"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-dd-invoice.svg"
                                                                                alt="modernize-img" class="img-fluid"
                                                                                width="24" height="24" />
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-1 fw-semibold fs-3">Invoice
                                                                                App</h6>
                                                                            <span
                                                                                class="fs-2 d-block text-body-secondary">Get
                                                                                latest invoice</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="{{ asset('template/back') }}/../main/app-contact2.html"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-dd-mobile.svg"
                                                                                alt="modernize-img" class="img-fluid"
                                                                                width="24" height="24" />
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-1 fw-semibold fs-3">
                                                                                Contact Application
                                                                            </h6>
                                                                            <span
                                                                                class="fs-2 d-block text-body-secondary">2
                                                                                Unsaved Contacts</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="{{ asset('template/back') }}/../main/app-email.html"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-dd-message-box.svg"
                                                                                alt="modernize-img" class="img-fluid"
                                                                                width="24" height="24" />
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-1 fw-semibold fs-3">Email App
                                                                            </h6>
                                                                            <span
                                                                                class="fs-2 d-block text-body-secondary">Get
                                                                                new emails</span>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="position-relative">
                                                                    <a href="{{ asset('template/back') }}/../main/page-user-profile.html"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-dd-cart.svg"
                                                                                alt="modernize-img" class="img-fluid"
                                                                                width="24" height="24" />
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-1 fw-semibold fs-3">
                                                                                User Profile
                                                                            </h6>
                                                                            <span
                                                                                class="fs-2 d-block text-body-secondary">learn
                                                                                more information</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="{{ asset('template/back') }}/../main/app-calendar.html"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-dd-date.svg"
                                                                                alt="modernize-img" class="img-fluid"
                                                                                width="24" height="24" />
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-1 fw-semibold fs-3">
                                                                                Calendar App
                                                                            </h6>
                                                                            <span
                                                                                class="fs-2 d-block text-body-secondary">Get
                                                                                dates</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="{{ asset('template/back') }}/../main/app-contact.html"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-dd-lifebuoy.svg"
                                                                                alt="modernize-img" class="img-fluid"
                                                                                width="24" height="24" />
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-1 fw-semibold fs-3">
                                                                                Contact List Table
                                                                            </h6>
                                                                            <span
                                                                                class="fs-2 d-block text-body-secondary">Add
                                                                                new contact</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="{{ asset('template/back') }}/../main/app-notes.html"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-dd-application.svg"
                                                                                alt="modernize-img" class="img-fluid"
                                                                                width="24" height="24" />
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-1 fw-semibold fs-3">
                                                                                Notes Application
                                                                            </h6>
                                                                            <span
                                                                                class="fs-2 d-block text-body-secondary">To-do
                                                                                and Daily tasks</span>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center py-3">
                                                        <div class="col-8">
                                                            <a class="fw-semibold d-flex align-items-center lh-1"
                                                                href="javascript:void(0)">
                                                                <i class="ti ti-help fs-6 me-2"></i>Frequently Asked
                                                                Questions
                                                            </a>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="d-flex justify-content-end pe-4">
                                                                <button class="btn btn-primary">Check</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 ms-n4">
                                                <div class="position-relative p-7 border-start h-100">
                                                    <h5 class="fs-5 mb-9 fw-semibold">Quick Links</h5>
                                                    <ul class="">
                                                        <li class="mb-3">
                                                            <a class="fw-semibold bg-hover-primary"
                                                                href="{{ asset('template/back') }}/../main/page-pricing.html">Pricing Page</a>
                                                        </li>
                                                        <li class="mb-3">
                                                            <a class="fw-semibold bg-hover-primary"
                                                                href="{{ asset('template/back') }}/../main/authentication-login.html">Authentication
                                                                Design</a>
                                                        </li>
                                                        <li class="mb-3">
                                                            <a class="fw-semibold bg-hover-primary"
                                                                href="{{ asset('template/back') }}/../main/authentication-register.html">Register
                                                                Now</a>
                                                        </li>
                                                        <li class="mb-3">
                                                            <a class="fw-semibold bg-hover-primary"
                                                                href="{{ asset('template/back') }}/../main/authentication-error.html">404 Error
                                                                Page</a>
                                                        </li>
                                                        <li class="mb-3">
                                                            <a class="fw-semibold bg-hover-primary"
                                                                href="{{ asset('template/back') }}/../main/app-notes.html">Notes App</a>
                                                        </li>
                                                        <li class="mb-3">
                                                            <a class="fw-semibold bg-hover-primary"
                                                                href="{{ asset('template/back') }}/../main/page-user-profile.html">User
                                                                Application</a>
                                                        </li>
                                                        <li class="mb-3">
                                                            <a class="fw-semibold bg-hover-primary"
                                                                href="{{ asset('template/back') }}/../main/page-account-settings.html">Account
                                                                Settings</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!-- ------------------------------- -->
                            <!-- end apps Dropdown -->
                            <!-- ------------------------------- -->
                            <li class="nav-item dropdown-hover d-none d-lg-block">
                                <a class="nav-link" href="{{ asset('template/back') }}/../main/app-chat.html">Chat</a>
                            </li>
                            <li class="nav-item dropdown-hover d-none d-lg-block">
                                <a class="nav-link" href="{{ asset('template/back') }}/../main/app-calendar.html">Calendar</a>
                            </li>
                            <li class="nav-item dropdown-hover d-none d-lg-block">
                                <a class="nav-link" href="{{ asset('template/back') }}/../main/app-email.html">Email</a>
                            </li>
                        </ul>
                        <div class="d-block d-xl-none">
                            <a href="{{ asset('template/back') }}/../main/index.html" class="text-nowrap nav-link">
                                <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/logos/dark-logo.svg" width="180" alt="modernize-img" />
                            </a>
                        </div>
                        <a class="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0"
                            href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="p-2">
                                <i class="ti ti-dots fs-7"></i>
                            </span>
                        </a>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <div class="d-flex align-items-center justify-content-between px-0 px-xl-8">
                                <a href="javascript:void(0)"
                                    class="nav-link round-40 p-1 ps-0 d-flex d-xl-none align-items-center justify-content-center"
                                    type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                                    aria-controls="offcanvasWithBothOptions">
                                    <i class="ti ti-align-justified fs-7"></i>
                                </a>
                                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                                    <!-- ------------------------------- -->
                                    <!-- start language Dropdown -->
                                    <!-- ------------------------------- -->
                                    <li class="nav-item nav-icon-hover-bg rounded-circle">
                                        <a class="nav-link moon dark-layout" href="javascript:void(0)">
                                            <i class="ti ti-moon moon"></i>
                                        </a>
                                        <a class="nav-link sun light-layout" href="javascript:void(0)">
                                            <i class="ti ti-sun sun"></i>
                                        </a>
                                    </li>
                                    <li class="nav-item nav-icon-hover-bg rounded-circle dropdown">
                                        <a class="nav-link" href="javascript:void(0)" id="drop2" aria-expanded="false">
                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-flag-en.svg" alt="modernize-img"
                                                width="20px" height="20px"
                                                class="rounded-circle object-fit-cover round-20" />
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                            aria-labelledby="drop2">
                                            <div class="message-body">
                                                <a href="javascript:void(0)"
                                                    class="d-flex align-items-center gap-2 py-3 px-4 dropdown-item">
                                                    <div class="position-relative">
                                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-flag-en.svg"
                                                            alt="modernize-img" width="20px" height="20px"
                                                            class="rounded-circle object-fit-cover round-20" />
                                                    </div>
                                                    <p class="mb-0 fs-3">English (UK)</p>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="d-flex align-items-center gap-2 py-3 px-4 dropdown-item">
                                                    <div class="position-relative">
                                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-flag-cn.svg"
                                                            alt="modernize-img" width="20px" height="20px"
                                                            class="rounded-circle object-fit-cover round-20" />
                                                    </div>
                                                    <p class="mb-0 fs-3">中国人 (Chinese)</p>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="d-flex align-items-center gap-2 py-3 px-4 dropdown-item">
                                                    <div class="position-relative">
                                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-flag-fr.svg"
                                                            alt="modernize-img" width="20px" height="20px"
                                                            class="rounded-circle object-fit-cover round-20" />
                                                    </div>
                                                    <p class="mb-0 fs-3">français (French)</p>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="d-flex align-items-center gap-2 py-3 px-4 dropdown-item">
                                                    <div class="position-relative">
                                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-flag-sa.svg"
                                                            alt="modernize-img" width="20px" height="20px"
                                                            class="rounded-circle object-fit-cover round-20" />
                                                    </div>
                                                    <p class="mb-0 fs-3">عربي (Arabic)</p>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- ------------------------------- -->
                                    <!-- end language Dropdown -->
                                    <!-- ------------------------------- -->

                                    <!-- ------------------------------- -->
                                    <!-- start shopping cart Dropdown -->
                                    <!-- ------------------------------- -->
                                    <li class="nav-item nav-icon-hover-bg rounded-circle">
                                        <a class="nav-link position-relative" href="javascript:void(0)"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                            aria-controls="offcanvasRight">
                                            <i class="ti ti-basket"></i>
                                            <span class="popup-badge rounded-pill bg-danger text-white fs-2">2</span>
                                        </a>
                                    </li>
                                    <!-- ------------------------------- -->
                                    <!-- end shopping cart Dropdown -->
                                    <!-- ------------------------------- -->

                                    <!-- ------------------------------- -->
                                    <!-- start notification Dropdown -->
                                    <!-- ------------------------------- -->
                                    <li class="nav-item nav-icon-hover-bg rounded-circle dropdown">
                                        <a class="nav-link position-relative" href="javascript:void(0)" id="drop2"
                                            aria-expanded="false">
                                            <i class="ti ti-bell-ringing"></i>
                                            <div class="notification bg-primary rounded-circle"></div>
                                        </a>
                                        <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                            aria-labelledby="drop2">
                                            <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                                <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                                                <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">5
                                                    new</span>
                                            </div>
                                            <div class="message-body" data-simplebar>
                                                <a href="javascript:void(0)"
                                                    class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                    <span class="me-3">
                                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-2.jpg" alt="user"
                                                            class="rounded-circle" width="48" height="48" />
                                                    </span>
                                                    <div class="w-100">
                                                        <h6 class="mb-1 fw-semibold lh-base">Roman Joined the Team!</h6>
                                                        <span class="fs-2 d-block text-body-secondary">Congratulate
                                                            him</span>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                    <span class="me-3">
                                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-3.jpg" alt="user"
                                                            class="rounded-circle" width="48" height="48" />
                                                    </span>
                                                    <div class="w-100">
                                                        <h6 class="mb-1 fw-semibold lh-base">New message</h6>
                                                        <span class="fs-2 d-block text-body-secondary">Salma sent you
                                                            new message</span>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                    <span class="me-3">
                                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-4.jpg" alt="user"
                                                            class="rounded-circle" width="48" height="48" />
                                                    </span>
                                                    <div class="w-100">
                                                        <h6 class="mb-1 fw-semibold lh-base">Bianca sent payment</h6>
                                                        <span class="fs-2 d-block text-body-secondary">Check your
                                                            earnings</span>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                    <span class="me-3">
                                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-5.jpg" alt="user"
                                                            class="rounded-circle" width="48" height="48" />
                                                    </span>
                                                    <div class="w-100">
                                                        <h6 class="mb-1 fw-semibold lh-base">Jolly completed tasks</h6>
                                                        <span class="fs-2 d-block text-body-secondary">Assign her new
                                                            tasks</span>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                    <span class="me-3">
                                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-6.jpg" alt="user"
                                                            class="rounded-circle" width="48" height="48" />
                                                    </span>
                                                    <div class="w-100">
                                                        <h6 class="mb-1 fw-semibold lh-base">John received payment</h6>
                                                        <span class="fs-2 d-block text-body-secondary">$230 deducted
                                                            from account</span>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                    <span class="me-3">
                                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-7.jpg" alt="user"
                                                            class="rounded-circle" width="48" height="48" />
                                                    </span>
                                                    <div class="w-100">
                                                        <h6 class="mb-1 fw-semibold lh-base">Roman Joined the Team!</h6>
                                                        <span class="fs-2 d-block text-body-secondary">Congratulate
                                                            him</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="py-6 px-7 mb-1">
                                                <button class="btn btn-outline-primary w-100">See All
                                                    Notifications</button>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- ------------------------------- -->
                                    <!-- end notification Dropdown -->
                                    <!-- ------------------------------- -->

                                    <!-- ------------------------------- -->
                                    <!-- start profile Dropdown -->
                                    <!-- ------------------------------- -->
                                    <li class="nav-item dropdown">
                                        <a class="nav-link pe-0" href="javascript:void(0)" id="drop1"
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <div class="user-profile-img">
                                                    <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-1.jpg"
                                                        class="rounded-circle" width="35" height="35"
                                                        alt="modernize-img" />
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                            aria-labelledby="drop1">
                                            <div class="profile-dropdown position-relative" data-simplebar>
                                                <div class="py-3 px-7 pb-0">
                                                    <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                                                </div>
                                                <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                                    <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-1.jpg"
                                                        class="rounded-circle" width="80" height="80"
                                                        alt="modernize-img" />
                                                    <div class="ms-3">
                                                        <h5 class="mb-1 fs-3">Mathew Anderson</h5>
                                                        <span class="mb-1 d-block">Designer</span>
                                                        <p class="mb-0 d-flex align-items-center gap-2">
                                                            <i class="ti ti-mail fs-4"></i> info@modernize.com
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="message-body">
                                                    <a href="{{ asset('template/back') }}/../main/page-user-profile.html"
                                                        class="py-8 px-7 mt-8 d-flex align-items-center">
                                                        <span
                                                            class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-account.svg"
                                                                alt="modernize-img" width="24" height="24" />
                                                        </span>
                                                        <div class="w-100 ps-3">
                                                            <h6 class="mb-1 fs-3 fw-semibold lh-base">My Profile</h6>
                                                            <span class="fs-2 d-block text-body-secondary">Account
                                                                Settings</span>
                                                        </div>
                                                    </a>
                                                    <a href="{{ asset('template/back') }}/../main/app-email.html"
                                                        class="py-8 px-7 d-flex align-items-center">
                                                        <span
                                                            class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-inbox.svg"
                                                                alt="modernize-img" width="24" height="24" />
                                                        </span>
                                                        <div class="w-100 ps-3">
                                                            <h6 class="mb-1 fs-3 fw-semibold lh-base">My Inbox</h6>
                                                            <span class="fs-2 d-block text-body-secondary">Messages &
                                                                Emails</span>
                                                        </div>
                                                    </a>
                                                    <a href="{{ asset('template/back') }}/../main/app-notes.html"
                                                        class="py-8 px-7 d-flex align-items-center">
                                                        <span
                                                            class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-tasks.svg"
                                                                alt="modernize-img" width="24" height="24" />
                                                        </span>
                                                        <div class="w-100 ps-3">
                                                            <h6 class="mb-1 fs-3 fw-semibold lh-base">My Task</h6>
                                                            <span class="fs-2 d-block text-body-secondary">To-do and
                                                                Daily Tasks</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="d-grid py-4 px-7 pt-8">
                                                    <div
                                                        class="upgrade-plan bg-primary-subtle position-relative overflow-hidden rounded-4 p-4 mb-9">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <h5 class="fs-4 mb-3 fw-semibold">Unlimited Access</h5>
                                                                <button class="btn btn-primary">Upgrade</button>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="m-n4 unlimited-img">
                                                                    <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/backgrounds/unlimited-bg.png"
                                                                        alt="modernize-img" class="w-100" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ asset('template/back') }}/../main/authentication-login.html"
                                                        class="btn btn-outline-primary">Log Out</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- ------------------------------- -->
                                    <!-- end profile Dropdown -->
                                    <!-- ------------------------------- -->
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </header>
            <!--  Header End -->

            <aside class="left-sidebar with-horizontal">
                <!-- Sidebar scroll-->
                <div>
                    <!-- Sidebar navigation-->
                    <nav id="sidebarnavh" class="sidebar-nav scroll-sidebar container-fluid">
                        <ul id="sidebarnav">
                            <!-- ============================= -->
                            <!-- Home -->
                            <!-- ============================= -->
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Beranda</span>
                            </li>
                            <!-- =================== -->
                            <!-- Dashboard -->
                            <!-- =================== -->
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-home-2"></i>
                                    </span>
                                    <span class="hide-menu">Dashboard</span>
                                </a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <li class="sidebar-item">
                                        <a href="{{ asset('template/back') }}/../main/index.html" class="sidebar-link">
                                            <i class="ti ti-aperture"></i>
                                            <span class="hide-menu">Dashboard</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <!-- ============================= -->
                            <!-- Home -->
                            <!-- ============================= -->
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Master</span>
                            </li>
                            <!-- =================== -->
                            <!-- Dashboard -->
                            <!-- =================== -->
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-home-2"></i>
                                    </span>
                                    <span class="hide-menu">Master</span>
                                </a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <li class="sidebar-item">
                                        <a href="{{ asset('template/back') }}/../main/index.html" class="sidebar-link">
                                            <i class="ti ti-aperture"></i>
                                            <span class="hide-menu">Pengguna</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>


                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->

            </aside>

            <div class="body-wrapper">
                <div class="container-fluid">


                    @yield('content')


                </div>
            </div>
            <script>
                function handleColorTheme(e) {
                    document.documentElement.setAttribute("data-color-theme", e);
                }
            </script>
            <button
                class="btn btn-primary p-3 rounded-circle d-flex align-items-center justify-content-center customizer-btn"
                type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                aria-controls="offcanvasExample">
                <i class="icon ti ti-settings fs-7"></i>
            </button>

            <div class="offcanvas customizer offcanvas-end" tabindex="-1" id="offcanvasExample"
                aria-labelledby="offcanvasExampleLabel">
                <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                    <h4 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">
                        Settings
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body h-n80" data-simplebar>
                    <h6 class="fw-semibold fs-4 mb-2">Theme</h6>

                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <input type="radio" class="btn-check light-layout" name="theme-layout" id="light-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary rounded-2" for="light-layout">
                            <i class="icon ti ti-brightness-up fs-7 me-2"></i>Light
                        </label>

                        <input type="radio" class="btn-check dark-layout" name="theme-layout" id="dark-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary rounded-2" for="dark-layout">
                            <i class="icon ti ti-moon fs-7 me-2"></i>Dark
                        </label>
                    </div>

                    <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Direction</h6>
                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <input type="radio" class="btn-check" name="direction-l" id="ltr-layout" autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="ltr-layout">
                            <i class="icon ti ti-text-direction-ltr fs-7 me-2"></i>LTR
                        </label>

                        <input type="radio" class="btn-check" name="direction-l" id="rtl-layout" autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="rtl-layout">
                            <i class="icon ti ti-text-direction-rtl fs-7 me-2"></i>RTL
                        </label>
                    </div>

                    <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Colors</h6>

                    <div class="d-flex flex-row flex-wrap gap-3 customizer-box color-pallete" role="group">
                        <input type="radio" class="btn-check" name="color-theme-layout" id="Blue_Theme"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Blue_Theme')" for="Blue_Theme" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="BLUE_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-1">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>

                        <input type="radio" class="btn-check" name="color-theme-layout" id="Aqua_Theme"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Aqua_Theme')" for="Aqua_Theme" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="AQUA_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-2">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>

                        <input type="radio" class="btn-check" name="color-theme-layout" id="Purple_Theme"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Purple_Theme')" for="Purple_Theme" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="PURPLE_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-3">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>

                        <input type="radio" class="btn-check" name="color-theme-layout" id="green-theme-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Green_Theme')" for="green-theme-layout" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="GREEN_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-4">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>

                        <input type="radio" class="btn-check" name="color-theme-layout" id="cyan-theme-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Cyan_Theme')" for="cyan-theme-layout" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="CYAN_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-5">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>

                        <input type="radio" class="btn-check" name="color-theme-layout" id="orange-theme-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Orange_Theme')" for="orange-theme-layout"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ORANGE_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-6">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>
                    </div>

                    <h6 class="mt-5 fw-semibold fs-4 mb-2">Layout Type</h6>
                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <div>
                            <input type="radio" class="btn-check" name="page-layout" id="vertical-layout"
                                autocomplete="off" />
                            <label class="btn p-9 btn-outline-primary" for="vertical-layout">
                                <i class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Vertical
                            </label>
                        </div>
                        <div>
                            <input type="radio" class="btn-check" name="page-layout" id="horizontal-layout"
                                autocomplete="off" />
                            <label class="btn p-9 btn-outline-primary" for="horizontal-layout">
                                <i class="icon ti ti-layout-navbar fs-7 me-2"></i>Horizontal
                            </label>
                        </div>
                    </div>

                    <h6 class="mt-5 fw-semibold fs-4 mb-2">Container Option</h6>

                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <input type="radio" class="btn-check" name="layout" id="boxed-layout" autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="boxed-layout">
                            <i class="icon ti ti-layout-distribute-vertical fs-7 me-2"></i>Boxed
                        </label>

                        <input type="radio" class="btn-check" name="layout" id="full-layout" autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="full-layout">
                            <i class="icon ti ti-layout-distribute-horizontal fs-7 me-2"></i>Full
                        </label>
                    </div>

                    <h6 class="fw-semibold fs-4 mb-2 mt-5">Sidebar Type</h6>
                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <a href="javascript:void(0)" class="fullsidebar">
                            <input type="radio" class="btn-check" name="sidebar-type" id="full-sidebar"
                                autocomplete="off" />
                            <label class="btn p-9 btn-outline-primary" for="full-sidebar">
                                <i class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Full
                            </label>
                        </a>
                        <div>
                            <input type="radio" class="btn-check " name="sidebar-type" id="mini-sidebar"
                                autocomplete="off" />
                            <label class="btn p-9 btn-outline-primary" for="mini-sidebar">
                                <i class="icon ti ti-layout-sidebar fs-7 me-2"></i>Collapse
                            </label>
                        </div>
                    </div>

                    <h6 class="mt-5 fw-semibold fs-4 mb-2">Card With</h6>

                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <input type="radio" class="btn-check" name="card-layout" id="card-with-border"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="card-with-border">
                            <i class="icon ti ti-border-outer fs-7 me-2"></i>Border
                        </label>

                        <input type="radio" class="btn-check" name="card-layout" id="card-without-border"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="card-without-border">
                            <i class="icon ti ti-border-none fs-7 me-2"></i>Shadow
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!--  Search Bar -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content rounded-1">
                    <div class="modal-header border-bottom">
                        <input type="search" class="form-control fs-3" placeholder="Search here" id="search" />
                        <a href="javascript:void(0)" data-bs-dismiss="modal" class="lh-1">
                            <i class="ti ti-x fs-5 ms-3"></i>
                        </a>
                    </div>
                    <div class="modal-body message-body" data-simplebar="">
                        <h5 class="mb-0 fs-5 p-1">Quick Page Links</h5>
                        <ul class="list mb-0 py-2">
                            <li class="p-1 mb-1 bg-hover-light-black">
                                <a href="javascript:void(0)">
                                    <span class="d-block">Modern</span>
                                    <span class="text-muted d-block">/dashboards/dashboard1</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black">
                                <a href="javascript:void(0)">
                                    <span class="d-block">Dashboard</span>
                                    <span class="text-muted d-block">/dashboards/dashboard2</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black">
                                <a href="javascript:void(0)">
                                    <span class="d-block">Contacts</span>
                                    <span class="text-muted d-block">/apps/contacts</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black">
                                <a href="javascript:void(0)">
                                    <span class="d-block">Posts</span>
                                    <span class="text-muted d-block">/apps/blog/posts</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black">
                                <a href="javascript:void(0)">
                                    <span class="d-block">Detail</span>
                                    <span
                                        class="text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black">
                                <a href="javascript:void(0)">
                                    <span class="d-block">Shop</span>
                                    <span class="text-muted d-block">/apps/ecommerce/shop</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black">
                                <a href="javascript:void(0)">
                                    <span class="d-block">Modern</span>
                                    <span class="text-muted d-block">/dashboards/dashboard1</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black">
                                <a href="javascript:void(0)">
                                    <span class="d-block">Dashboard</span>
                                    <span class="text-muted d-block">/dashboards/dashboard2</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black">
                                <a href="javascript:void(0)">
                                    <span class="d-block">Contacts</span>
                                    <span class="text-muted d-block">/apps/contacts</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black">
                                <a href="javascript:void(0)">
                                    <span class="d-block">Posts</span>
                                    <span class="text-muted d-block">/apps/blog/posts</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black">
                                <a href="javascript:void(0)">
                                    <span class="d-block">Detail</span>
                                    <span
                                        class="text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black">
                                <a href="javascript:void(0)">
                                    <span class="d-block">Shop</span>
                                    <span class="text-muted d-block">/apps/ecommerce/shop</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--  Shopping Cart -->
        <div class="offcanvas offcanvas-end shopping-cart" tabindex="-1" id="offcanvasRight"
            aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header justify-content-between py-4">
                <h5 class="offcanvas-title fs-5 fw-semibold" id="offcanvasRightLabel">
                    Shopping Cart
                </h5>
                <span class="badge bg-primary rounded-4 px-3 py-1 lh-sm">5 new</span>
            </div>
            <div class="offcanvas-body h-100 px-4 pt-0" data-simplebar>
                <ul class="mb-0">
                    <li class="pb-7">
                        <div class="d-flex align-items-center">
                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/products/product-1.jpg" width="95" height="75"
                                class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
                            <div>
                                <h6 class="mb-1">Supreme toys cooker</h6>
                                <p class="mb-0 text-muted fs-2">Kitchenware Item</p>
                                <div class="d-flex align-items-center justify-content-between mt-2">
                                    <h6 class="fs-2 fw-semibold mb-0 text-muted">$250</h6>
                                    <div class="input-group input-group-sm w-50">
                                        <button class="btn border-0 round-20 minus p-0 bg-success-subtle text-success"
                                            type="button" id="add1">
                                            -
                                        </button>
                                        <input type="text"
                                            class="form-control round-20 bg-transparent text-muted fs-2 border-0 text-center qty"
                                            placeholder="" aria-label="Example text with button addon"
                                            aria-describedby="add1" value="1" />
                                        <button class="btn text-success bg-success-subtle p-0 round-20 border-0 add"
                                            type="button" id="addo2">
                                            +
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="pb-7">
                        <div class="d-flex align-items-center">
                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/products/product-2.jpg" width="95" height="75"
                                class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
                            <div>
                                <h6 class="mb-1">Supreme toys cooker</h6>
                                <p class="mb-0 text-muted fs-2">Kitchenware Item</p>
                                <div class="d-flex align-items-center justify-content-between mt-2">
                                    <h6 class="fs-2 fw-semibold mb-0 text-muted">$250</h6>
                                    <div class="input-group input-group-sm w-50">
                                        <button class="btn border-0 round-20 minus p-0 bg-success-subtle text-success"
                                            type="button" id="add2">
                                            -
                                        </button>
                                        <input type="text"
                                            class="form-control round-20 bg-transparent text-muted fs-2 border-0 text-center qty"
                                            placeholder="" aria-label="Example text with button addon"
                                            aria-describedby="add2" value="1" />
                                        <button class="btn text-success bg-success-subtle p-0 round-20 border-0 add"
                                            type="button" id="addon34">
                                            +
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="pb-7">
                        <div class="d-flex align-items-center">
                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/products/product-3.jpg" width="95" height="75"
                                class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
                            <div>
                                <h6 class="mb-1">Supreme toys cooker</h6>
                                <p class="mb-0 text-muted fs-2">Kitchenware Item</p>
                                <div class="d-flex align-items-center justify-content-between mt-2">
                                    <h6 class="fs-2 fw-semibold mb-0 text-muted">$250</h6>
                                    <div class="input-group input-group-sm w-50">
                                        <button class="btn border-0 round-20 minus p-0 bg-success-subtle text-success"
                                            type="button" id="add3">
                                            -
                                        </button>
                                        <input type="text"
                                            class="form-control round-20 bg-transparent text-muted fs-2 border-0 text-center qty"
                                            placeholder="" aria-label="Example text with button addon"
                                            aria-describedby="add3" value="1" />
                                        <button class="btn text-success bg-success-subtle p-0 round-20 border-0 add"
                                            type="button" id="addon3">
                                            +
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="align-bottom">
                    <div class="d-flex align-items-center pb-7">
                        <span class="text-dark fs-3">Sub Total</span>
                        <div class="ms-auto">
                            <span class="text-dark fw-semibold fs-3">$2530</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center pb-7">
                        <span class="text-dark fs-3">Total</span>
                        <div class="ms-auto">
                            <span class="text-dark fw-semibold fs-3">$6830</span>
                        </div>
                    </div>
                    <a href="{{ asset('template/back') }}/../main/eco-checkout.html" class="btn btn-outline-primary w-100">Go to shopping cart</a>
                </div>
            </div>
        </div>
    </div>
    <div class="dark-transparent sidebartoggler"></div>
    <script src="{{ asset('template/back') }}/dist/js/vendor.min.js"></script>
    <!-- Import Js Files -->
    <script src="{{ asset('template/back') }}/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template/back') }}/dist/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="{{ asset('template/back') }}/dist/js/theme/app.init.js"></script>
    <script src="{{ asset('template/back') }}/dist/js/theme/theme.js"></script>
    <script src="{{ asset('template/back') }}/dist/js/theme/app.min.js"></script>
    <script src="{{ asset('template/back') }}/dist/js/theme/sidebarmenu.js"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
    <!-- <script src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/libs/apexcharts/dist/apexcharts.min.js"></script> -->
    <!-- <script src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/js/dashboards/dashboard.js"></script> -->


    <!-- <script src="{{ asset('template/back') }}/dist/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('template/back') }}/dist/js/datatable/datatable-basic.init.js"></script> -->
    @stack('script')
</body>

</html>