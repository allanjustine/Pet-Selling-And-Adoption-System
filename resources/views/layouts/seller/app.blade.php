<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'Dashboard')</title>
    @include('layouts.seller.styles')
    @yield('styles')
</head>

<body class="">


    {{-- <div id="loading-screen">
        <div class="loader"></div>
    </div> --}}


    @include('layouts.seller.modal')
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
                        {{-- <li class="nav-item">
                            <a class="nav-link @if (Route::is('seller.dashboard.index')) active @endif"
                                href="{{ route('seller.dashboard.index') }}">
                                <i class="fas fa-laptop"></i>
                                <span class="nav-link-text">Dashboard</span>
                            </a>
                        </li> --}}

                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('seller.pets.*') || Route::is('seller.adoptions.*')) active @endif"
                                href="#to_pet_management" data-toggle="collapse" role="button" aria-expanded="false"
                                aria-controls="navbar-tables">
                                <i class="fas fa-paw"></i>
                                <span class="nav-link-text">
                                    Pet Management
                                </span>
                            </a>
                            <div class="collapse @if (Route::is('seller.categories.index') || Route::is('seller.breeds.index') || Route::is('seller.pets.*')) show @endif" id="to_pet_management">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('seller.pets.index') }}"
                                            class="nav-link @if (Route::is('seller.pets.*')) text-primary @endif">
                                            Selling
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('seller.adoptions.index') }}"
                                            class="nav-link @if (Route::is('seller.adoptions.*')) text-primary @endif">
                                            Adoption
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('seller.orders.*')) active @endif"
                                href="{{ route('seller.orders.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="nav-link-text">Order Management</span>
                                <span class="badge badge-warning  ml-1">0</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('messages.*')) active @endif"
                                href="{{ route('messages.index') }}">
                                <i class="fas fa-envelope"></i>
                                <span class="nav-link-text">Inbox</span>
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
                            <a class="nav-link" href="{{ route('profile.index') }}" id="profile_nav">
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
                                    <h6 class="text-overflow m-0">Menu</h6>
                                </div>

                                @if (auth()->user()->hasRole('seller'))
                                    <a href="javascript:void(0)" class="dropdown-item"
                                        onclick="promptUpdate(event, '#switch_account', 'Do you want to switch account?')">
                                        <i class="fa fa-store"></i>
                                        <span>Switch to Buyer Account</span>
                                    </a>

                                    <form action="{{ route('seller.switch_account.update', auth()->user()) }}"
                                        method="POST" id="switch_account">
                                        @csrf @method('PUT')
                                    </form>
                                @endif



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

        @if (session('switch_account_response'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show p-3 text-white mt-3" role="alert">
                    {{ session('switch_account_response') ?? '' }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        @yield('content')

    </div>
    {{-- End Main Content --}}

    @include('layouts.seller.scripts')
    <script src="{{ asset('assets/js/seller/script.js') }}"></script>
    @yield('script')
    @routes

</body>

</html>
