@extends('layouts.frontend')

@section('title', 'Confirmación de Reserva')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm text-center">
                <div class="card-header bg-success text-white">
                    <h1 class="h4 mb-0">¡Reserva Confirmada!</h1>
                </div>
                <div class="card-body p-5">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(isset($reservation))
                        <p class="lead">Gracias, <strong>{{ $reservation->client->name }}</strong>.</p>
                        <p>Tu reserva para el <strong>{{ \Carbon\Carbon::parse($reservation->reservation_datetime)->format('d/m/Y \a \l\a\s H:i') }}</strong>
                           en la mesa <strong>{{ $reservation->table->name }}</strong> para <strong>{{ $reservation->number_of_guests }}</strong> comensal(es) ha sido registrada exitosamente.</p>
                        <p>Hemos enviado un correo de confirmación a <strong>{{ $reservation->client->email }}</strong> (si la funcionalidad de email está implementada).</p>
                        <p>Tu número de referencia es: <strong>RES-{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</strong></p>
                        <hr>
                        <p class="text-muted">Por favor, llega unos minutos antes. Si necesitas cancelar o modificar tu reserva, contáctanos.</p>
                    @else
                         <p class="lead">¡Gracias por tu reserva!</p>
                         <p>Hemos recibido tu solicitud y te contactaremos pronto para confirmar los detalles.</p>
                         <p class="text-muted">Si la confirmación automática estaba habilitada, revisa tu correo electrónico.</p>
                    @endif

                    <a href="{{ route('home') }}" class="btn btn-primary mt-4">Volver a la Página Principal</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection