<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/boxicons.min.css">

    <style>
        .link_btn{
            background-color: #FFFFFF;
            border-radius: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        /* Elevación sutil global para mejorar el contraste sobre fondo blanco */
        .card{
            box-shadow: 0 8px 18px rgba(2, 6, 23, 0.06);
        }
        /* Contenedor de tablas con leve sombra y fondo blanco */
        .table-responsive{
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(2, 6, 23, 0.05);
        }
        .table{ margin-bottom: 0; }
        /* Encabezado de tabla ligeramente diferenciado */
        .table thead th{ border-bottom-color: rgba(2,6,23,0.06); }

        /* Otros componentes comunes */
        .list-group{
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(2, 6, 23, 0.05);
        }
        .modal-content{
            border: 0;
            border-radius: 14px;
            box-shadow: 0 20px 40px rgba(2, 6, 23, 0.15);
        }
        .dropdown-menu{
            border: 0;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(2, 6, 23, 0.12);
        }
        .offcanvas{
            box-shadow: 0 24px 48px rgba(2, 6, 23, 0.18);
        }

        /* Utilidades opcionales para usar donde se requiera */
        .shadow-soft{ box-shadow: 0 8px 18px rgba(2, 6, 23, 0.06) !important; }
        .shadow-soft-lg{ box-shadow: 0 16px 32px rgba(2, 6, 23, 0.10) !important; }
        .shadow-hover{ transition: box-shadow .2s ease; }
        .shadow-hover:hover{ box-shadow: 0 14px 28px rgba(2, 6, 23, 0.12) !important; }
    </style>

    @yield('head')
</head>

<body id="body-pd">
    <style>
        .gradient-top-bar{height:4px;background:linear-gradient(90deg,#22c55e 0%,#4f46e5 100%)}
        .navbar-modern{border:0;border-radius:14px;margin-top:10px}
        .navbar-modern .navbar-nav{flex-wrap:wrap}
        .navbar-modern .nav-link{border-radius:8px;color:#334155;padding:.4rem .6rem;display:flex;align-items:center;gap:.3rem;font-weight:500;font-size:.92rem}
        .navbar-modern .nav-link i{font-size:1rem}
        .navbar-modern .nav-link:hover{background:#f1f5f9;color:#0f172a}
        .navbar-modern .nav-link.active{background:rgba(34,197,94,.12);color:#059669}
        .navbar-brand .app-name{font-weight:700;color:#0f172a;font-size:1rem}
        .avatar-circle{width:32px;height:32px;border-radius:50%;background:#198754;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:16px}
        .dropdown-menu .dropdown-item{font-size:.92rem}
        .dropdown-menu .dropdown-item i{width:18px;margin-right:.35rem}
        @media (max-width: 1400px){
            .navbar-modern .nav-link{font-size:.88rem;padding:.35rem .55rem}
            .navbar-brand .app-name{font-size:.95rem}
        }
        @media (max-width: 1200px){
            .navbar-modern .nav-link{font-size:.85rem;padding:.3rem .5rem}
            .navbar-brand .app-name{display:none}
        }
    </style>

    <div class="gradient-top-bar"></div>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top navbar-modern container">
        <div class="container-fluid px-2">
            <a class="navbar-brand d-flex align-items-center gap-2" href="/">
                <img src="/img/Logo.png" alt="{{ config('app.name') }}" width="40" class="d-inline-block align-text-top">
                <span class="app-name d-none d-sm-inline">{{ config('app.name') }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto gap-1">
                    @php
                        $modules = null;
                        if (Auth()->user()->role == 'Administrador') {
                            $modules = App\Models\Users\Module::all();
                        } else {
                            $modules = Auth()->user()->modules();
                        }
                    @endphp
                    @foreach ($modules as $module)
                        @php
                            $routeName = $module->access_route_name;
                            $isActive = Route::has($routeName) && request()->routeIs($routeName.'*');
                        @endphp
                        <li class="nav-item">
                            <a href="{{ Route::has($routeName) ? route($routeName) : '#' }}" class="nav-link {{ $isActive ? 'active' : '' }}">
                                <i class='bx {{ $module->icon }}'></i>
                                <span>{{ $module->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="avatar-circle"><i class='bx bxs-user'></i></span>
                            <span class="d-none d-sm-inline">{{ Auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><h6 class="dropdown-header">Cuenta</h6></li>
                            <li><a class="dropdown-item" href="{{ route('users.showChangePassword') }}"><i class='bx bx-key'></i> Cambiar contraseña</a></li>
                            <li><a class="dropdown-item" href="{{ route('about') }}"><i class='bx bx-info-circle'></i> Acerca de</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class='bx bxs-x-circle'></i> Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    {{-- <div class="l-navbar" id="nav-bar">
        <nav class="nav d-flex flex-column justify-content-between" id="nav">
            <div>
                <div class="nav_list">
                    <a href="/" class="nav_logo logo-toggle nav_module_name"><img src="/img/Logo.png" id="imagen2" width="120"/></a>
                </div>
                <div class="nav_list mt-5">
                    @php
                        $modules = null;
                        if (Auth()->user()->role == 'Administrador')
                        {
                            $modules = App\Models\Users\Module::all();
                        }
                        else
                        {
                            $modules = Auth()->user()->modules();
                        }
                    @endphp
                    @foreach ($modules as $module)
                        <a href="{{Route::has($module->access_route_name) ? route($module->access_route_name) : ''}}" class="nav_link"><i class='bx {{$module->icon}} nav_icon'></i><span class="nav_name nav_module_name">{{$module->name}}</span></a>
                    @endforeach
                </div>
            </div>
            <div style="" class="d-flex flex-column justify-content-end gap-3 align-items-center">
                <div class="nav_list mt-2 w-100">
                    <a href="{{Route('users.showChangePassword')}}" class="nav_link"><i class='bx bx-key nav_icon'></i><span class="nav_name nav_module_name">Cambiar Contraseña</span></a>
                </div>
                <div class="d-flex flex-column w-100">
                    <div class="d-flex flex-column post_user justify-content-between align-items-start">

                        <div class="d-flex  justify-content-between w-100 p-2">
                            <span class="nav_module_name">{{Auth()->user()->name}}</span>
                            <a class="d-flex justify-content-between align-items-center text-decoration-none" href="{{route('logout')}}"> <i class='bx bxs-x-circle icon_block' ></i></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div> --}}


    @if ($errors->any())
        <x-error-messages :errors="$errors->all()" />
    @endif
    @if (session('message'))
        <x-message :message="session('message')" :color="session('type') ?? 'success'" />
    @endif

    <main class="mt-3 w-100">
        @yield('content')
    </main>

    <script src="/js/bootstrap.bundle.js"></script>
    @yield('scripts')
    @yield('scripts2')
    @yield('scripts3')
    @stack('scripts')
</body>
</html>
