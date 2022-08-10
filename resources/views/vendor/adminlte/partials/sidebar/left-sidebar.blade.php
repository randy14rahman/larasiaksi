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
    'icon' => 'fas fa-fw fa-home'
    ],[
    'text' => 'Surat Masuk',
    'url' => '/surat-masuk',
    'icon' => 'far fa-fw fa-envelope',
    'label' => 4,
    'label_color' => 'success',
    ],
    [
    'text' => 'Surat Keluar',
    'url' => '/surat-keluar',
    'icon' => 'far fa-fw fa-envelope',
    'label' => 4,
    'label_color' => 'success',
    ],
    [
    'text' => 'Arsip',
    'url' => '/arsip',
    'icon' => 'fas fa-fw fa-archive'
    ]];

    $menuadmin=[[
    'text' => 'User Management',
    'url' => '/admin/users',
    'icon' => 'fas fa-fw fa-users'
    ],
    [
    'text' => 'Role Management',
    'url' => '/admin/roles',
    'icon' => 'fas fa-fw fa-lock'
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
    $isadmin=true;

    $user_role = auth()->user()->role_id;
    @endphp

    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu" @if(config('adminlte.sidebar_nav_animation_speed') !=300)
                data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}" @endif <!--
                @if(!config('adminlte.sidebar_nav_accordion')) data-accordion="false" @endif>
                @foreach ($menu as $item)
                <i @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item">
                    <a class="nav-link @isset($item['shift']) {{ $item['shift'] }} @endisset" href="{{ $item['url'] }}"
                        @isset($item['url']) @endisset {!! $item['data-compiled'] ?? '' !!}>
                        <i class="{{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{
                            isset($item['icon_color']) ? 'text-'.$item['icon_color'] : ''
                        }}"></i>
                        <p>
                            {{ $item['text'] }}
                        </p>
                    </a> </i>
                @endforeach
                @if($user_role==1)
                <li class="nav-header">
                    Admin
                </li>
                @foreach ($menuadmin as $item)

                <i @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item">
                    <a class="nav-link @isset($item['shift']) {{ $item['shift'] }} @endisset" href="{{ $item['url'] }}"
                        @isset($item['url']) @endisset {!! $item['data-compiled'] ?? '' !!}>
                        <i class="{{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{
                            isset($item['icon_color']) ? 'text-'.$item['icon_color'] : ''
                        }}"></i>
                        <p>
                            {{ $item['text'] }}
                        </p>
                    </a> </i>
                @endforeach
                @endif
                <li class="nav-header">
                    Administrator
                </li>
                @foreach ($menuprofile as $item)
                <i @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item">
                    <a class="nav-link @isset($item['shift']) {{ $item['shift'] }} @endisset" href="{{ $item['url'] }}"
                        @isset($item['url']) @endisset {!! $item['data-compiled'] ?? '' !!}>
                        <i class="{{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{
                            isset($item['icon_color']) ? 'text-'.$item['icon_color'] : ''
                        }}"></i>
                        <p>
                            {{ $item['text'] }}
                        </p>
                    </a> </i>
                @endforeach




            </ul>
        </nav>
    </div>

</aside>