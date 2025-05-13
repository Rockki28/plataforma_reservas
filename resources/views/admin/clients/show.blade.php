@extends('layouts.admin')

@section('title', 'Detalle del Cliente: ' . $client->name)

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Cliente: {{ $client->name }}</h5>
        {{-- <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit me-2"></i> Editar Cliente</a> --}}
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h6>Información de Contacto:</h6>
                <ul class="list-unstyled">
                    <li><strong>ID:</strong> {{ $client->id }}</li>
                    <li><strong>Nombre:</strong> {{ $client->name }}</li>
                    <li><strong>Email:</strong> <a href="mailto:{{ $client->email }}">{{ $client->email }}</a></li>
                    <li><strong>Teléfono:</strong> {{ $client->phone ?? 'No registrado' }}</li>
                    <li><strong>Registrado:</strong> {{ $client->created_at->format('d/m/Y H:i') }}</li>
                </ul>
            </div>
            {{-- Puedes añadir más detalles del cliente si los tienes --}}
        </div>

        @if(isset($client->reservations) && $client->reservations->count() > 0)
            <h6>Historial de Reservas ({{ $client->reservations->count() }})</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID Reserva</th>
                            <th>Mesa</th>
                            <th>Fecha y Hora</th>
                            <th>Comensales</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client->reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>{{ $reservation->table->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->reservation_datetime)->format('d/m/Y H:i') }}</td>
                            <td>{{ $reservation->number_of_guests }}</td>
                            <td>
                                <span class="badge 
                                    @if($reservation->status == 'confirmed') bg-success
                                    @elseif($reservation->status == 'pending') bg-warning text-dark
                                    @elseif($reservation->status == 'cancelled') bg-danger
                                    @elseif($reservation->status == 'completed') bg-info text-dark
                                    @else bg-secondary @endif">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="btn btn-xs btn-outline-primary" title="Ver Reserva"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">Este cliente no tiene reservas registradas.</p>
        @endif
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('admin.clients.index') }}" class="btn btn-outline-secondary">Volver al Listado de Clientes</a>
    </div>
</div>
@endsection