@extends('layouts.admin')

@section('title', 'Gestión de Clientes')

@section('content')
{{-- <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Nuevo Cliente</a>
</div> --}}

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Todos los Clientes</h5>
    </div>
    <div class="card-body">
        @if(isset($clients) && $clients->count())
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Reservas</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->id }}</td>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->phone ?? 'N/A' }}</td>
                            <td>{{ $client->reservations_count ?? $client->reservations->count() }}</td> {{-- Asume que 'reservations_count' se carga o se cuenta --}}
                            <td class="text-end">
                                <a href="{{ route('admin.clients.show', $client->id) }}" class="btn btn-sm btn-info" title="Ver Detalles"><i class="fas fa-eye"></i></a>
                                {{-- Podrías añadir botones de editar/eliminar si la lógica lo permite --}}
                                {{-- 
                                <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este cliente? Esto podría afectar sus reservas.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                                </form> 
                                --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center">No hay clientes registrados.</div>
        @endif
    </div>
    @if(isset($clients) && $clients->hasPages())
    <div class="card-footer">
        {{ $clients->links() }}
    </div>
    @endif
</div>
@endsection