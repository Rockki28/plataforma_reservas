@extends('layouts.admin')

@section('title', 'Gestión de Reservas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    {{-- El título h1 ya está en el layout, pero puedes añadir un subtítulo si quieres --}}
    {{-- <h2>Listado de Reservas</h2> --}}
    <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Nueva Reserva</a>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Todas las Reservas</h5>
    </div>
    <div class="card-body">
        @if($reservations->count())
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Email</th>
                            <th>Mesa</th>
                            <th>Fecha y Hora</th>
                            <th>Comensales</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>{{ $reservation->client->name ?? 'N/A' }}</td>
                            <td>{{ $reservation->client->email ?? 'N/A' }}</td>
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
                            <td class="text-end">
                                <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="btn btn-sm btn-info" title="Ver"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta reserva? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center">No hay reservas registradas.</div>
        @endif
    </div>
    @if($reservations->hasPages())
    <div class="card-footer">
        {{ $reservations->links() }}
    </div>
    @endif
</div>
@endsection