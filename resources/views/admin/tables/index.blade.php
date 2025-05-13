@extends('layouts.admin')

@section('title', 'Gestión de Mesas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('admin.tables.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Nueva Mesa</a>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Todas las Mesas</h5>
    </div>
    <div class="card-body">
        @if($tables->count())
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Capacidad</th>
                            <th>Ubicación/Descripción</th>
                            <th>Disponible</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tables as $table)
                        <tr>
                            <td>{{ $table->id }}</td>
                            <td>{{ $table->name }}</td>
                            <td>{{ $table->capacity }}</td>
                            <td>{{ $table->location_description ?? 'N/A' }}</td>
                            <td>
                                @if($table->is_available)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-danger">No</span>
                                @endif
                            </td>
                            <td class="text-end">
                                {{-- <a href="{{ route('admin.tables.show', $table->id) }}" class="btn btn-sm btn-info" title="Ver"><i class="fas fa-eye"></i></a> --}}
                                <a href="{{ route('admin.tables.edit', $table->id) }}" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.tables.destroy', $table->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta mesa? Si tiene reservas asociadas, podrían surgir problemas.');">
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
            <div class="alert alert-info text-center">No hay mesas registradas.</div>
        @endif
    </div>
     @if($tables->hasPages())
    <div class="card-footer">
        {{ $tables->links() }}
    </div>
    @endif
</div>
@endsection