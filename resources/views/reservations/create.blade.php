@extends('layouts.frontend')

@section('title', 'Crear Reserva')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Realizar una Reserva</h1>
                </div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('reservations.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="client_name" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('client_name') is-invalid @enderror" id="client_name" name="client_name" value="{{ old('client_name') }}" required>
                            @error('client_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="client_email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('client_email') is-invalid @enderror" id="client_email" name="client_email" value="{{ old('client_email') }}" required>
                            @error('client_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="client_phone" class="form-label">Teléfono <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('client_phone') is-invalid @enderror" id="client_phone" name="client_phone" value="{{ old('client_phone') }}" required>
                            @error('client_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="reservation_datetime" class="form-label">Fecha y Hora de Reserva <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('reservation_datetime') is-invalid @enderror" id="reservation_datetime" name="reservation_datetime" value="{{ old('reservation_datetime') }}" required>
                                @error('reservation_datetime')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="number_of_guests" class="form-label">Número de Comensales <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('number_of_guests') is-invalid @enderror" id="number_of_guests" name="number_of_guests" value="{{ old('number_of_guests', 1) }}" min="1" required>
                                @error('number_of_guests')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="table_id" class="form-label">Seleccionar Mesa <span class="text-danger">*</span></label>
                            <select class="form-select @error('table_id') is-invalid @enderror" id="table_id" name="table_id" required>
                                <option value="" disabled {{ old('table_id') ? '' : 'selected' }}>Elija una mesa...</option>
                                @if(isset($availableTables) && $availableTables->count())
                                    @foreach($availableTables as $table)
                                        <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                                            {{ $table->name }} (Capacidad: {{ $table->capacity }}) - {{ $table->location_description ?? 'Sin ubicación específica' }}
                                        </option>
                                    @endforeach
                                @else
                                 <option value="" disabled>No hay mesas disponibles en este momento.</option>
                                @endif
                            </select>
                            @error('table_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-text">
                            <small>Los campos marcados con <span class="text-danger">*</span> son obligatorios.</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Confirmar Reserva</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection