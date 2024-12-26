<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'Admin | Dashboard')</title>
    @include('layouts.admin.styles')
    @yield('styles')
</head>

<body>
    @include('layouts.admin.modal')
    {{-- Side Nav --}}
    <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="sidenav-header d-flex align-items-center">
                <img class="navbar-brand mt-3" src="{{ handleNullAvatar(auth()->user()->avatar_profile) }}" width="115"
                    alt="avatar" title="{{ auth()->user()->name }}">
                <div class="d-block d-lg-none">
                    <div class="sidenav-toggler" data-action="sidenav-unpin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <h6 class="navbar-heading p-0 text-muted mt-2 mt-md-0 mb-1">
                        <span class="docs-normal">{{ auth()->user()->role->name }}</span>
                    </h6>
                    <!-- Nav items -->
                    <ul class="navbar-nav mt-1 mt-md-0">
                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('admin.dashboard.index')) active @endif"
                                href="{{ route('admin.dashboard.index') }}">
                                <i class="ni ni-tv-2"></i>
                                <span class="nav-link-text">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('admin.categories.*') ||
                                    Route::is('admin.breeds.index') ||
                                    Route::is('admin.pets.*') ||
                                    Route::is('admin.adoptions.*')) active @endif"
                                href="#to_pet_management" data-toggle="collapse" role="button" aria-expanded="false"
                                aria-controls="navbar-tables">
                                <i class="fas fa-paw"></i>
                                <span class="nav-link-text">
                                    Pet Management
                                </span>
                            </a>
                            <div class="collapse @if (Route::is('admin.categories.*') ||
                                    Route::is('admin.breeds.index') ||
                                    Route::is('admin.pets.*') ||
                                    Route::is('admin.adoptions.*')) show @endif" id="to_pet_management">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.categories.index') }}"
                                            class="nav-link @if (Route::is('admin.categories.*')) text-primary @endif">
                                            Category
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.breeds.index') }}"
                                            class="nav-link @if (Route::is('admin.breeds.index')) text-primary @endif">
                                            Breed
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.pets.index') }}"
                                            class="nav-link @if (Route::is('admin.pets.*')) text-primary @endif">
                                            Pet for Sale
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.adoptions.index') }}"
                                            class="nav-link @if (Route::is('admin.adoptions.*')) text-primary @endif">
                                            Pet for Adoption
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('admin.orders.*')) active @endif"
                                href="{{ route('admin.orders.index') }}" id="order_management_nav">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="nav-link-text">Order Management</span>
                                <span class="badge badge-warning  ml-1">{{ $order_count }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('admin.payment_methods.index')) active @endif"
                                href="{{ route('admin.payment_methods.index') }}" id="payment_method_nav">
                                <i class="fas fa-credit-card"></i>
                                <span class="nav-link-text">Payment Method</span>
                            </a>
                        </li>



                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('admin.admins.*') ||
                                    Route::is('admin.buyers.*') ||
                                    Route::is('admin.sellers.*') ||
                                    Route::is('admin.users.*')) active @endif"
                                href="#to_user_management" data-toggle="collapse" role="button" aria-expanded="false"
                                aria-controls="navbar-tables">
                                <i class="fas fa-user-cog"></i>
                                <span class="nav-link-text">
                                    User Management
                                </span>
                            </a>
                            <div class="collapse @if (Route::is('admin.admins.*') ||
                                    Route::is('admin.buyers.*') ||
                                    Route::is('admin.sellers.*') ||
                                    Route::is('admin.users.*')) show @endif"
                                id="to_user_management">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.admins.index') }}"
                                            class="nav-link @if (Route::is('admin.admins.*')) text-primary @endif">
                                            Admin
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.buyers.index') }}"
                                            class="nav-link @if (Route::is('admin.buyers.index')) text-primary @endif">
                                            Buyer
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.sellers.index') }}"
                                            class="nav-link @if (Route::is('admin.sellers.index')) text-primary @endif">
                                            Seller
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.users.index') }}"
                                            class="nav-link @if (Route::is('admin.users.index')) text-primary @endif">
                                            Authorization
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('admin.activity_logs.index')) active @endif"
                                href="{{ route('admin.activity_logs.index') }}">
                                <i class="fas fa-history"></i>
                                <span class="nav-link-text">Activity Logs</span>
                            </a>
                        </li>

                    </ul>




                    <!-- Divider -->
                    <hr class="my-3">
                    <!-- Heading -->
                    <h6 class="navbar-heading p-0 text-muted">
                        <span class="docs-normal">Analytics</span>
                    </h6>

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('admin.general_report.index')) active @endif"
                                href="{{ route('admin.general_report.index') }}">
                                <i class="fas fa-project-diagram"></i>
                                <span class="nav-link-text">General Report</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Divider -->
                    <hr class="my-3">
                    <!-- Heading -->
                    <h6 class="navbar-heading p-0 text-muted">
                        <span class="docs-normal">Settings</span>
                    </h6>
                    <!-- Navigation -->
                    <ul class="navbar-nav mb-md-3">
                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('profile.index')) active @endif"
                                href="{{ route('profile.index') }}">
                                <i class="ni ni-single-02"></i>
                                <span class="nav-link-text">Profile</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav> {{-- End Side Nav --}}

    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Navbar links -->
                    <ul class="navbar-nav align-items-center  ml-md-auto ">
                        <li class="nav-item">
                            <!-- Sidenav toggler -->
                            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
                                data-target="#sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        <img src="{{ handleNullAvatar(auth()->user()->avatar_profile) }}"
                                            class="avatar rounded-circle" alt="Image placeholder">
                                    </span>
                                    <div class="media-body  ml-2  d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }}</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu  dropdown-menu-right ">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Settings</h6>
                                </div>
                                <a href="{{ route('profile.index') }}" class="dropdown-item">
                                    <i class="ni ni-single-02"></i>
                                    <span>Profile</span>
                                </a>

                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0)" class="dropdown-item"
                                    onclick="confirm('Do you want to Logout?', '', 'Yes').then(res => res.isConfirmed ? $('#logout').submit() : false)">
                                    <i class="fas fa-power-off"></i>
                                    <span>Logout</span>
                                </a>
                                <form action="{{ route('auth.logout') }}" method="post" id="logout">@csrf</form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header -->

        @yield('content')

    </div>
    {{-- End Main Content --}}

    @include('layouts.admin.scripts')
    <script src="{{ asset('assets/js/admin/script.js') }}"></script>
    @yield('script')
    @routes

</body>

</html>
