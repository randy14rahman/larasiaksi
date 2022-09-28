@php
use Zend\Debug\Debug;
//Debug::dump(app('request')->routeIs('home'));
@endphp
<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
    @include('adminlte::partials.common.brand-logo-xl')
    @else
    @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}

    @php
    $menu=[[
    'text' => 'Dashboard',
    'url' => '/home',
    'icon' => 'fa-duotone fa-house',
    'shift' => app('request')->routeIs('home') ? 'active' : ''
    ],[
    'text' => 'Surat Masuk',
    'url' => '/surat-masuk',
    'icon' => 'fa-duotone fa-inbox-in',
    'label' => 4,
    'label_color' => 'success',
    'shift' => app('request')->routeIs('surat-masuk.*') ? 'active' : ''
    ],
    [
    'text' => 'Surat Keluar',
    'url' => '/surat-keluar',
    'icon' => 'fa-duotone fa-inbox-out',
    'label' => 4,
    'label_color' => 'success',
    'shift' => app('request')->routeIs('surat-keluar.*') ? 'active' : ''
    ],
    [
    'text' => 'Arsip',
    'url' => '/arsip',
    'icon' => 'fa-duotone fa-box-archive',
    'shift' => app('request')->routeIs('arsip.*') ? 'active' : ''
    ]];

    $menuadmin=[[
    'text' => 'User Management',
    'url' => '/admin/users',
    'icon' => 'fas fa-fw fa-users',
    'shift' => app('request')->routeIs('users') ? 'active' : ''
    ],
    [
    'text' => 'Role Management',
    'url' => '/admin/roles',
    'icon' => 'fas fa-fw fa-lock',
    'shift' => app('request')->routeIs('roles') ? 'active' : ''
    ]];

    $menuprofile =[
    [
    'text' => 'profile',
    'url' => 'admin/settings',
    'icon' => 'fas fa-fw fa-user',
    ],
    [
    'text' => 'change_password',
    'url' => 'admin/settings',
    'icon' => 'fas fa-fw fa-lock',
    ]];
    $menuprofile = [];
    $isadmin=true;

    $user_role = auth()->user()->role_id;
    @endphp

    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/assets/image/avatar-svgrepo-com.svg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="javascript:;" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu" @if(config('adminlte.sidebar_nav_animation_speed') !=300)
                data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}" @endif <!--
                @if(!config('adminlte.sidebar_nav_accordion')) data-accordion="false" @endif>
                @foreach ($menu as $item)
                <li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item">
                    <a class="nav-link @isset($item['shift']) {{ $item['shift'] }} @endisset" href="{{ $item['url'] }}"
                        @isset($item['url']) @endisset {!! $item['data-compiled'] ?? '' !!}>
                        <i class="{{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{
                            isset($item['icon_color']) ? 'text-'.$item['icon_color'] : ''
                        }}"></i>
                        <p class="ml-1">{{ $item['text'] }}</p>
                    </a> </li>
                @endforeach
                @if($user_role==1)
                <li class="nav-header">
                    Admin
                </li>
                @foreach ($menuadmin as $item)

                <li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item">
                    <a class="nav-link @isset($item['shift']) {{ $item['shift'] }} @endisset" href="{{ $item['url'] }}"
                        @isset($item['url']) @endisset {!! $item['data-compiled'] ?? '' !!}>
                        <i class="{{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{
                            isset($item['icon_color']) ? 'text-'.$item['icon_color'] : ''
                        }}"></i>
                        <p>
                            {{ $item['text'] }}
                        </p>
                    </a> </li>
                @endforeach
                @endif
                <li class="nav-header d-none">
                    Administrator
                </li>
                @foreach ($menuprofile as $item)
                <li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item">
                    <a class="nav-link @isset($item['shift']) {{ $item['shift'] }} @endisset" href="{{ $item['url'] }}"
                        @isset($item['url']) @endisset {!! $item['data-compiled'] ?? '' !!}>
                        <i class="{{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{
                            isset($item['icon_color']) ? 'text-'.$item['icon_color'] : ''
                        }}"></i>
                        <p>
                            {{ $item['text'] }}
                        </p>
                    </a> </li>
                @endforeach




            </ul>
        </nav>
    </div>

</aside>