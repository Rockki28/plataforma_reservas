@extends('layouts.admin')

@section('title', 'Detalle de Reserva #' . $reservation->id)

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detalles de la Reserva #{{ $reservation->id }}</h5>
        <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit me-2"></i> Editar Reserva</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6>Información del Cliente:</h6>
                <ul class="list-unstyled">
                    <li><strong>Nombre:</strong> {{ $reservation->client->name ?? 'N/A' }}</li>
                    <li><strong>Email:</strong> {{ $reservation->client->email ?? 'N/A' }}</li>
                    <li><strong>Teléfono:</strong> {{ $reservation->client->phone ?? 'N/A' }}</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6>Información de la Reserva:</h6>
                <ul class="list-unstyled">
                    <li><strong>Mesa:</strong> {{ $reservation->table->name ?? 'N/A' }} (Cap: {{ $reservation->table->capacity ?? 'N/A' }})</li>
                    <li><strong>Fecha y Hora:</strong> {{ \Carbon\Carbon::parse($reservation->reservation_datetime)->format('l, d \d\e F \d\e Y \a \l\a\s H:i') }}</li>
                    <li><strong>Número de Comensales:</strong> {{ $reservation->number_of_guests }}</li>
                    <li><strong>Estado:</strong> 
                        <span class="badge 
                            @if($reservation->status == 'confirmed') bg-success
                            @elseif($reservation->status == 'pending') bg-warning text-dark
                            @elseif($reservation->status == 'cancelled') bg-danger
                            @elseif($reservation->status == 'completed') bg-info text-dark
                            @else bg-secondary @endif">
                            {{ ucfirst($reservation->status) }}
                        </span>
                    </li>
                    <li><strong>Creada:</strong> {{ $reservation->created_at->format('d/m/Y H:i') }}</li>
                    <li><strong>Última Actualización:</strong> {{ $reservation->updated_at->format('d/m/Y H:i') }}</li>
                </ul>
            </div>
        </div>
        
        @if($reservation->notes)
        <hr>
        <h6>Notas Adicionales:</h6>
        <p>{{ $reservation->notes }}</p>
        @endif

    </div>
    <div class="card-footer text-end">
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">Volver al Listado</a>
    </div>
</div>
@endsection