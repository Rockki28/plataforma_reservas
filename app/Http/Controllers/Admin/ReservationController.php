<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table; // Para select de mesas en formularios
use App\Models\Client; // Para select de clientes en formularios
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Muestra un listado de todas las reservas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $reservations = Reservation::with(['client', 'table']) // Carga ansiosa para eficiencia
                                   ->orderBy('reservation_datetime', 'desc')
                                   ->paginate(15); // Paginación

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Muestra el formulario para crear una nueva reserva (si el admin puede crearlas).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
         // Necesario para los selects en el formulario
        $clients = Client::orderBy('name')->get();
        $tables = Table::orderBy('name')->get(); // O filtrar por disponibilidad si es relevante

        return view('admin.reservations.create', compact('clients', 'tables'));
    }

    /**
     * Almacena una nueva reserva creada por el administrador.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'table_id' => 'required|exists:tables,id',
            'reservation_datetime' => 'required|date',
            'number_of_guests' => 'required|integer|min:1',
            'status' => 'required|in:confirmed,pending,cancelled,completed', // Ajusta los estados según necesites
        ]);

        // Validación adicional de disponibilidad si es necesario

        Reservation::create($validatedData);

        return redirect()->route('admin.reservations.index')
                         ->with('success', 'Reserva creada exitosamente.');
    }

    /**
     * Muestra los detalles de una reserva específica.
     * Se usa Route-Model Binding.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\View\View
     */
    public function show(Reservation $reservation)
    {
        // Cargar relaciones si no se cargaron automáticamente o se necesitan más
        $reservation->load(['client', 'table']);
        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Muestra el formulario para editar una reserva existente.
     * Se usa Route-Model Binding.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\View\View
     */
    public function edit(Reservation $reservation)
    {
        // Necesario para los selects en el formulario
        $clients = Client::orderBy('name')->get();
        $tables = Table::orderBy('name')->get();
        $statuses = ['confirmed', 'pending', 'cancelled', 'completed']; // Ejemplo de estados

        return view('admin.reservations.edit', compact('reservation', 'clients', 'tables', 'statuses'));
    }

    /**
     * Actualiza una reserva específica en la base de datos.
     * Se usa Route-Model Binding.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'table_id' => 'required|exists:tables,id',
            'reservation_datetime' => 'required|date',
            'number_of_guests' => 'required|integer|min:1',
            'status' => 'required|in:confirmed,pending,cancelled,completed',
        ]);

         // Validación adicional de disponibilidad si es necesario

        $reservation->update($validatedData);

        return redirect()->route('admin.reservations.index')
                         ->with('success', 'Reserva actualizada exitosamente.');
    }

    /**
     * Elimina una reserva específica de la base de datos.
     * Se usa Route-Model Binding.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reservation $reservation)
    {
        try {
            $reservation->delete();
            return redirect()->route('admin.reservations.index')
                             ->with('success', 'Reserva eliminada exitosamente.');
        } catch (\Exception $e) {
            // Log::error(...)
            return redirect()->route('admin.reservations.index')
                             ->with('error', 'Error al eliminar la reserva.');
        }
    }
}