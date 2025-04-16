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
    </style>

    @yield('head')
</head>

<body id="body-pd">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="/img/Logo.png" alt="{{ config('app.name') }}" width="60" class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                @php
                    $modules = null;
                    if (Auth()->user()->role == 'Administrador') {
                        $modules = App\Models\Users\Module::all();
                    } else {
                        $modules = Auth()->user()->modules();
                    }
                @endphp
                @foreach ($modules as $module)
                    <li class="nav-item">
                        <a href="{{ Route::has($module->access_route_name) ? route($module->access_route_name) : '' }}" class="nav-link active" style="color: rgb(65, 77, 43)">
                            <i class='bx {{ $module->icon }} nav_icon'></i>
                            {{ $module->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" style="color: rgb(65, 77, 43)" href="{{route('logout')}}">
                        <i class='bx bxs-x-circle'></i> Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    {{-- <header class="header" id="header">
        <div class="dropdown">
            <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('logout')}}">Cerrar Sesión</a></li>
            </ul>
        </div>
    </header> --}}
    <!-- Header -->
    {{-- <div class="header-wrapper"></div> --}}
 
   <!-- Sidebar -->
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
