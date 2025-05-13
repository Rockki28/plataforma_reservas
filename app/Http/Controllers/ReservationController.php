<?php

namespace App\Http\Controllers;

use App\Models\Client; // Importa el modelo Client
use App\Models\Reservation;
use App\Models\Table; // Importa el modelo Table para buscar disponibilidad
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Si se implementa historial/cancelación para usuarios logueados
use Illuminate\Support\Facades\Log; // Para depuración si es necesario
use Carbon\Carbon; // Para manejar fechas y horas

class ReservationController extends Controller
{
    /**
     * Muestra el formulario para crear una nueva reserva.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Aquí podrías cargar datos necesarios para el formulario,
        // como las mesas disponibles o los horarios permitidos.
        // Por simplicidad, asumimos que esto se maneja en el frontend
        // o se carga de forma dinámica.
        $availableTables = Table::where('is_available', true)->get(); // Ejemplo básico

        return view('reservations.create', compact('availableTables'));
    }

    /**
     * Almacena una nueva reserva enviada desde el formulario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $validatedData = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'reservation_datetime' => 'required|date|after:now', // Asegura que la fecha sea futura
            'number_of_guests' => 'required|integer|min:1',
            'table_id' => 'required|exists:tables,id', // Asegura que la mesa exista
            // Añade aquí cualquier otra validación necesaria (ej. horario permitido, etc.)
        ]);

        // Lógica para verificar disponibilidad (simplificada)
        // Una lógica más robusta verificaría si la mesa está ocupada en esa fecha/hora específica.
        $table = Table::find($validatedData['table_id']);
        if (!$table || !$table->is_available) {
             return back()->withErrors(['table_id' => 'La mesa seleccionada no está disponible.'])->withInput();
        }
        // Aquí iría una comprobación más compleja de conflictos de horario
        // $existingReservation = Reservation::where('table_id', $validatedData['table_id'])
        //      ->where('reservation_datetime', Carbon::parse($validatedData['reservation_datetime'])) // Cuidado con rangos de tiempo
        //      ->exists();
        // if($existingReservation) {
        //      return back()->withErrors(['reservation_datetime' => 'Ya existe una reserva para esta mesa en la hora seleccionada.'])->withInput();
        // }


        // Buscar o crear el cliente
        $client = Client::firstOrCreate(
            ['email' => $validatedData['client_email']], // Clave única para buscar
            [                                          // Datos para crear si no existe
                'name' => $validatedData['client_name'],
                'phone' => $validatedData['client_phone']
            ]
        );

        // Crear la reserva
        try {
            $reservation = Reservation::create([
                'client_id' => $client->id,
                'table_id' => $validatedData['table_id'],
                'reservation_datetime' => Carbon::parse($validatedData['reservation_datetime']),
                'number_of_guests' => $validatedData['number_of_guests'],
                'status' => 'confirmed', // O 'pending' si requiere confirmación del admin
                // 'restaurant_id' => $table->restaurant_id, // Asignar si es necesario y la relación existe en Table
            ]);

             // Guardar ID en sesión para la página de confirmación
             session()->flash('new_reservation_id', $reservation->id);

             // Redirigir a la página de confirmación
             return redirect()->route('reservations.confirmation');

        } catch (\Exception $e) {
            Log::error("Error al crear reserva: " . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al procesar tu reserva. Por favor, intenta de nuevo.')->withInput();
        }
    }

    /**
     * Muestra la página de confirmación de la reserva.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function confirmation()
    {
        $reservationId = session('new_reservation_id');

        if (!$reservationId) {
            // Si no hay ID en sesión, redirigir a la página de inicio o creación
            return redirect()->route('home')->with('error', 'No se encontró información de la reserva.');
        }

        // Recuperar la reserva (con datos relacionados si es necesario)
        $reservation = Reservation::with(['client', 'table'])->find($reservationId);

        if (!$reservation) {
            return redirect()->route('home')->with('error', 'No se pudo cargar la confirmación de la reserva.');
        }

        return view('reservations.confirmation', compact('reservation'));
    }

    /**
     * Muestra el historial de reservas del cliente autenticado (Opcional).
     * Requiere que los clientes tengan cuentas y estén logueados.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Asegúrate de que el middleware 'auth' esté aplicado a la ruta si usas esto
        // $user = Auth::user(); // Obtener el usuario autenticado
        // $reservations = Reservation::where('client_id', $user->client->id) // Asumiendo relación User -> Client
        //                         ->with(['table']) // Cargar datos relacionados
        //                         ->orderBy('reservation_datetime', 'desc')
        //                         ->paginate(10);

        // return view('reservations.index', compact('reservations'));

        // Si no hay autenticación de clientes, esta ruta podría no tener sentido
        // o mostrar algo diferente. Por ahora, redirigimos o mostramos un error.
         abort(404, 'Funcionalidad no implementada o requiere autenticación.');
    }

    /**
     * Muestra los detalles de una reserva específica del cliente (Opcional).
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\View\View
     */
    public function show(Reservation $reservation)
    {
        // Asegúrate de que el middleware 'auth' y la autorización (Gate/Policy)
        // estén aplicados para verificar que el usuario puede ver esta reserva.
        // $this->authorize('view', $reservation); // Ejemplo de autorización

        // return view('reservations.show', compact('reservation'));

        abort(404, 'Funcionalidad no implementada o requiere autenticación.');
    }


    /**
     * Cancela una reserva específica del cliente (Opcional).
     * Podría ser un método 'destroy' si sigue la convención RESTful,
     * o 'cancel' si se prefiere un nombre más descriptivo para la acción del usuario.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reservation $reservation) // o cancel(Reservation $reservation)
    {
        // Asegúrate de que el middleware 'auth' y la autorización (Gate/Policy)
        // estén aplicados para verificar que el usuario puede cancelar esta reserva.
        // $this->authorize('delete', $reservation); // Ejemplo de autorización

        // try {
        //     // Cambiar estado a 'cancelled' o eliminarla, según la lógica de negocio
        //     $reservation->status = 'cancelled';
        //     $reservation->save();
        //     // O $reservation->delete();

        //     return redirect()->route('reservations.index')->with('success', 'Reserva cancelada correctamente.');
        // } catch (\Exception $e) {
        //     Log::error("Error al cancelar reserva: " . $e->getMessage());
        //     return back()->with('error', 'No se pudo cancelar la reserva.');
        // }

        abort(404, 'Funcionalidad no implementada o requiere autenticación.');
    }
}