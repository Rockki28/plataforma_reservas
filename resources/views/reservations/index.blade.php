@extends('layouts.frontend')

@section('title', 'Mis Reservas')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Mis Reservas</h1>
        <a href="{{ route('reservations.create') }}" class="btn btn-primary">Nueva Reserva</a>
    </div>

    @if(isset($reservations) && $reservations->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID Reserva</th>
                                <th>Mesa</th>
                                <th>Fecha y Hora</th>
                                <th>Comensales</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                            <tr>
                                <td>RES-{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</td>
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
                                    {{-- Asumimos que existe una ruta 'reservations.show' para el cliente --}}
                                    {{-- <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-sm btn-info me-1" title="Ver Detalles"><i class="fas fa-eye"></i></a> --}}
                                    
                                    {{-- Asumimos que existe una ruta 'reservations.cancel' (o destroy) para el cliente --}}
                                    {{-- @if($reservation->status == 'confirmed' || $reservation->status == 'pending')
                                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas cancelar esta reserva?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Cancelar Reserva"><i class="fas fa-times-circle"></i></button>
                                    </form>
                                    @endif --}}
                                    <small class="text-muted">Contactar para cambios.</small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if($reservations->hasPages())
            <div class="card-footer">
                {{ $reservations->links() }}
            </div>
            @endif
        </div>
    @else
        <div class="alert alert-info text-center">
            <p class="lead mb-0">Aún no tienes reservas registradas.</p>
            <a href="{{ route('reservations.create') }}" class="btn btn-primary mt-3">¡Haz tu primera reserva ahora!</a>
        </div>
    @endif
</div>
@endsection

{{-- Si necesitas iconos de Font Awesome u otros --}}
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush