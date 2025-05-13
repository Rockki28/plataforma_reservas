@extends('layouts.admin')

@section('title', 'Editar Mesa: ' . $table->name)

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Editando Mesa: {{ $table->name }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.tables.update', $table->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nombre de la Mesa <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $table->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="capacity" class="form-label">Capacidad <span class="text-danger">*</span></label>
                <input type="number" name="capacity" id="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity', $table->capacity) }}" min="1" required>
                @error('capacity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="location_description" class="form-label">Ubicación / Descripción (Opcional)</label>
                <input type="text" name="location_description" id="location_description" class="form-control @error('location_description') is-invalid @enderror" value="{{ old('location_description', $table->location_description) }}">
                @error('location_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="is_available" class="form-label">Disponible <span class="text-danger">*</span></label>
                <select name="is_available" id="is_available" class="form-select @error('is_available') is-invalid @enderror" required>
                    <option value="1" {{ old('is_available', $table->is_available) == '1' ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ old('is_available', $table->is_available) == '0' ? 'selected' : '' }}>No</option>
                </select>
                @error('is_available')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Si las mesas pertenecen a un Restaurante --}}
            {{-- 
            @if(isset($restaurants) && $restaurants->count())
            <div class="mb-3">
                <label for="restaurant_id" class="form-label">Restaurante <span class="text-danger">*</span></label>
                <select name="restaurant_id" id="restaurant_id" class="form-select @error('restaurant_id') is-invalid @enderror" required>
                    <option value="" disabled>Seleccione un restaurante</option>
                    @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}" {{ old('restaurant_id', $table->restaurant_id) == $restaurant->id ? 'selected' : '' }}>{{ $restaurant->name }}</option>
                    @endforeach
                </select>
                @error('restaurant_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @endif 
            --}}

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.tables.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Mesa</button>
            </div>
        </form>
    </div>
</div>
@endsection