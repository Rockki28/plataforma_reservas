{{-- resources/views/layouts/frontend.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nombre de la Aplicación') }} - @yield('title', 'Bienvenido')</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @stack('styles')

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-content {
            flex: 1;
        }
    </style>
</head>
<body>
    <div id="frontend-app"> {{-- Cambiado el ID para evitar conflictos si 'app' se usa en Breeze --}}
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    {{ config('app.name', 'Nombre de la Aplicación') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#frontendNavbarSupportedContent" aria-controls="frontendNavbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="frontendNavbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            {{-- Asume que tienes una ruta o sección para el menú --}}
                            <a class="nav-link" href="{{-- {{ route('menu') }} --}}#menu-destacado">Menú</a>
                        </li>
                        <li class="nav-item">
                             {{-- Asume que tienes una ruta o sección para contacto --}}
                            <a class="nav-link" href="{{-- {{ route('contact') }} --}}#contact-section">Contacto</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('reservations.create') }}">Reservar Mesa</a>
                        </li>
                        {{-- Si quieres login/registro del sistema Breeze aquí, puedes enlazarlos --}}
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item ms-2">
                                    <a class="btn btn-outline-secondary" href="{{ route('login') }}">{{ __('Login Admin/Usuario') }}</a>
                                </li>
                            @endif
                            {{-- @if (Route::has('register'))
                                <li class="nav-item ms-2">
                                    <a class="btn btn-outline-success" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                </li>
                            @endif --}}
                        @else
                            {{-- Si el usuario está logueado con Breeze, podrías mostrar un enlace a su dashboard --}}
                            <li class="nav-item dropdown ms-2">
                                <a id="navbarUserDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserDropdown">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}"> {{-- Asume que 'dashboard' es la ruta del dashboard de Breeze --}}
                                        {{ __('Mi Cuenta') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form-frontend').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </a>
                                    <form id="logout-form-frontend" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 main-content">
            {{-- Mensajes flash para el frontend --}}
            <div class="container">
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
            </div>

            @yield('content') {{-- AQUÍ SE INYECTA EL CONTENIDO DE LAS VISTAS HIJAS DEL FRONTEND --}}
        </main>

        <footer class="bg-light text-center text-lg-start mt-auto">
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                © {{ date('Y') }} {{ config('app.name', 'Nombre de la Aplicación') }}. Todos los derechos reservados.
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>