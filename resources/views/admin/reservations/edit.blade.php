@extends('layouts.admin')

@section('title', 'Editar Reserva #' . $reservation->id)

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Editando Reserva #{{ $reservation->id }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="client_id" class="form-label">Cliente <span class="text-danger">*</span></label>
                    <select name="client_id" id="client_id" class="form-select @error('client_id') is-invalid @enderror" required>
                        <option value="" disabled>Seleccione un cliente</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id', $reservation->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }} ({{ $client->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="table_id" class="form-label">Mesa <span class="text-danger">*</span></label>
                    <select name="table_id" id="table_id" class="form-select @error('table_id') is-invalid @enderror" required>
                        <option value="" disabled>Seleccione una mesa</option>
                        @foreach($tables as $table)
                            <option value="{{ $table->id }}" {{ old('table_id', $reservation->table_id) == $table->id ? 'selected' : '' }}>
                                {{ $table->name }} (Cap: {{ $table->capacity }})
                            </option>
                        @endforeach
                    </select>
                    @error('table_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="reservation_datetime" class="form-label">Fecha y Hora <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="reservation_datetime" id="reservation_datetime" class="form-control @error('reservation_datetime') is-invalid @enderror" value="{{ old('reservation_datetime', \Carbon\Carbon::parse($reservation->reservation_datetime)->format('Y-m-d\TH:i')) }}" required>
                    @error('reservation_datetime')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="number_of_guests" class="form-label">Número de Comensales <span class="text-danger">*</span></label>
                    <input type="number" name="number_of_guests" id="number_of_guests" class="form-control @error('number_of_guests') is-invalid @enderror" value="{{ old('number_of_guests', $reservation->number_of_guests) }}" min="1" required>
                    @error('number_of_guests')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label">Estado <span class="text-danger">*</span></label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    @foreach($statuses as $statusValue)
                        <option value="{{ $statusValue }}" {{ old('status', $reservation->status) == $statusValue ? 'selected' : '' }}>
                            {{ ucfirst($statusValue) }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Campo opcional para notas --}}
            <div class="mb-3">
                <label for="notes" class="form-label">Notas Adicionales (Opcional)</label>
                <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $reservation->notes) }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Reserva</button>
            </div>
        </form>
    </div>
</div>
@endsection