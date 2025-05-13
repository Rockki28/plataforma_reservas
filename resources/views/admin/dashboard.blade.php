@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    {{-- El título principal ya está en el layout de admin, pero puedes añadir subtítulos o más info aquí --}}
    {{-- <h1 class="h2">Dashboard</h1> --}}
    <p>Bienvenido al panel de administración de {{ config('app.name', 'Restaurante') }}.</p>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Reservas Totales</h5>
                            <p class="card-text fs-2">{{ $totalReservations ?? 0 }}</p>
                        </div>
                        <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                    </div>
                    <a href="{{ route('admin.reservations.index') }}" class="text-white stretched-link">Ver detalles</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                     <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Mesas Registradas</h5>
                            <p class="card-text fs-2">{{ $totalTables ?? 0 }}</p>
                        </div>
                        <i class="fas fa-chair fa-3x opacity-50"></i>
                    </div>
                    <a href="{{ route('admin.tables.index') }}" class="text-white stretched-link">Gestionar mesas</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-info shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Clientes Registrados</h5>
                            <p class="card-text fs-2">{{ $totalClients ?? 0 }}</p>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                    <a href="{{ route('admin.clients.index') }}" class="text-white stretched-link">Ver clientes</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Aquí puedes añadir más secciones, gráficos o información relevante para el dashboard --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    Actividad Reciente (Ejemplo)
                </div>
                <div class="card-body">
                    <p>Próximamente: Listado de últimas reservas, comentarios, etc.</p>
                    {{-- Por ejemplo, podrías listar las próximas 5 reservas --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection