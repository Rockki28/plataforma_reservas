<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Panel de Administración') - {{ config('app.name', 'Nombre de la Aplicación') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <style>
        body {
            font-size: .875rem;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100; /* Behind the navbar */
            padding: 48px 0 0; /* Height of navbar */
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            width: 250px; /* Ancho de la barra lateral */
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
        }
        .main-content {
            margin-left: 250px; /* Mismo ancho que la barra lateral */
            padding-top: 48px; /* Para la barra de navegación superior fija */
        }
        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
            font-size: 1rem;
            background-color: rgba(0, 0, 0, .25);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        }
        .navbar .form-control {
            padding: .75rem 1rem;
            border-width: 0;
            border-radius: 0;
        }
        .top-navbar {
            z-index: 101; /* Encima de la barra lateral */
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow top-navbar">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ route('admin.dashboard') }}">{{ config('app.name') }} Admin</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        {{-- Puedes añadir un input de búsqueda o elementos a la derecha de la barra superior aquí si es necesario --}}
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="nav-link px-3" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     this.closest('form').submit();">
                        Cerrar Sesión ({{ Auth::user()->name }})
                    </a>
                </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt fa-fw me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}" href="{{ route('admin.reservations.index') }}">
                                <i class="fas fa-calendar-check fa-fw me-2"></i> Reservas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.tables.*') ? 'active' : '' }}" href="{{ route('admin.tables.index') }}">
                                <i class="fas fa-chair fa-fw me-2"></i> Mesas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}" href="{{ route('admin.clients.index') }}">
                                <i class="fas fa-users fa-fw me-2"></i> Clientes
                            </a>
                        </li>
                        {{-- Puedes añadir más elementos de menú aquí --}}
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog fa-fw me-2"></i> Configuración
                            </a>
                        </li> --}}
                    </ul>

                    {{-- Sección opcional para otros enlaces o reportes --}}
                    {{-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Reportes</span>
                        <a class="link-secondary" href="#" aria-label="Add a new report">
                            <span data-feather="plus-circle"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Reporte Mensual
                            </a>
                        </li>
                    </ul> --}}
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title', 'Panel de Administración')</h1>
                    {{-- Aquí puedes añadir botones de acción comunes como "Crear Nuevo" --}}
                    {{-- <div class="btn-toolbar mb-2 mb-md-0">
                        @yield('header-actions')
                    </div> --}}
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>