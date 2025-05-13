<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Muestra un listado de todos los clientes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $clients = Client::orderBy('name')->paginate(15);
        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Muestra el formulario para crear un nuevo cliente (si aplica).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
         // return view('admin.clients.create');
         abort(404); // O redirigir si no se implementa la creación directa por admin
    }

    /**
     * Almacena un nuevo cliente (si aplica).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|max:255|unique:clients,email',
        //     'phone' => 'required|string|max:20',
        // ]);

        // Client::create($validatedData);

        // return redirect()->route('admin.clients.index')
        //                  ->with('success', 'Cliente creado exitosamente.');
        abort(404);
    }

    /**
     * Muestra los detalles de un cliente específico.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\View\View
     */
    public function show(Client $client)
    {
        // Cargar relaciones si se quieren mostrar (ej. historial de reservas)
        $client->load(['reservations' => function ($query) {
            $query->with('table')->orderBy('reservation_datetime', 'desc');
        }]);

        return view('admin.clients.show', compact('client'));
    }

    /**
     * Muestra el formulario para editar un cliente existente (si aplica).
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\View\View
     */
    public function edit(Client $client)
    {
        // return view('admin.clients.edit', compact('client'));
        abort(404);
    }

    /**
     * Actualiza un cliente específico (si aplica).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Client $client)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|max:255|unique:clients,email,' . $client->id,
        //     'phone' => 'required|string|max:20',
        // ]);

        // $client->update($validatedData);

        // return redirect()->route('admin.clients.index')
        //                  ->with('success', 'Cliente actualizado exitosamente.');
         abort(404);
    }

    /**
     * Elimina un cliente específico (si aplica).
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Client $client)
    {
        // Considerar qué pasa con las reservas del cliente.
        // ¿Prevenir eliminación? ¿Anonimizar? ¿Eliminar en cascada?
        // if ($client->reservations()->count() > 0) {
        //     return back()->with('error', 'No se puede eliminar el cliente porque tiene reservas asociadas.');
        // }

        // try {
        //     $client->delete();
        //     return redirect()->route('admin.clients.index')
        //                      ->with('success', 'Cliente eliminado exitosamente.');
        // } catch (\Exception $e) {
        //     // Log::error(...)
        //     return redirect()->route('admin.clients.index')
        //                      ->with('error', 'Error al eliminar el cliente.');
        // }
        abort(404); // Comentado o eliminar si se implementa
    }
}
