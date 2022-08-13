@php
$user = auth()->user();
$user_role = auth()->user()->role_id;

$id_user = $user->id;

@endphp

<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>



    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        <!-- <div class="nav-item dropdown">
            <div class="nav-link dropdown-toggle"
                style="display:flex;align-items:center;justify-content:center;cursor:pointer" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="far fa-fw fa-bell" style="font-size: 25px;"></i>
                <div
                    style="display:flex;align-items:center;justify-content:center;width: 15px;height:15px;border-radius:50%;background-color:red;margin-left:-12px">
                    <span style="font-size: 8px;color:white">10</span>
                </div>
            </div>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div> -->

        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu link --}}

        {{-- @if(Auth::user())
            @if(config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif --}}
        @if($user_role !=1 && $user_role !=2)
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge" id="count_notification"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="container-notification">
                <!-- <span class="dropdown-item dropdown-header">15 Notifications</span> -->
                <!-- <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <p style="display:flex;flex-wrap: wrap;">Penugasan Surat <i class="ml-2"> 12/02/2000</i></p>
                    <div><span class="badge text-bg-primary" style="background-color:#198754;color:white">Surat
                            Masuk</span></div>
                    <div style="font-size: 12px;">2022-02-12</div>

                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <p style="display:flex;flex-wrap: wrap;"> Penugasan Surat <i class="ml-2">12/02/2000</i></p>
                    <div><span class="badge text-bg-primary" style="background-color:#198754;color:white">Surat
                            Masuk</span></div>
                    <div style="font-size: 12px;">2022-02-12</div>

                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <p style="display:flex;flex-wrap: wrap;"> Paraf Surat <i class="ml-2">12/02/2000</i></p>
                    <div><span class="badge text-bg-primary" style="background-color:#fd7e14;color:white">Surat
                            Keluar</span></div>
                    <div style="font-size: 12px;">2022-02-12</div>

                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <p style="display:flex;flex-wrap: wrap;"> Tandatangan Surat <i class="ml-2">12/02/2000</i></p>
                    <div><span class="badge text-bg-primary" style="background-color:#fd7e14;color:white">Surat
                            Keluar</span></div>
                    <div style="font-size: 12px;">2022-02-12</div>

                </a> -->

                <!-- <div class="dropdown-divider"></div> -->
                <!-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
            </div>
        </li>
        @endif
        <!-- Notifications Dropdown Menu -->

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        @include('adminlte::partials.navbar.menu-item-logout-link')

        {{-- Right sidebar toggler link --}}
        @if(config('adminlte.right_sidebar'))
        @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>