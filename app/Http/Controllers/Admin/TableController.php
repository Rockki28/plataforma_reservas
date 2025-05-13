<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
// Si las mesas pertenecen a un restaurante específico y tienes ese modelo:
// use App\Models\Restaurant;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Muestra un listado de todas las mesas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tables = Table::orderBy('name')->paginate(15);
        return view('admin.tables.index', compact('tables'));
    }

    /**
     * Muestra el formulario para crear una nueva mesa.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Cargar datos si las mesas dependen de otras entidades (ej. Restaurantes)
        // $restaurants = Restaurant::all();
        // return view('admin.tables.create', compact('restaurants'));
        return view('admin.tables.create');
    }

    /**
     * Almacena una nueva mesa en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:tables,name', // Nombre único de mesa
            'capacity' => 'required|integer|min:1',
            'location_description' => 'nullable|string|max:255', // Descripción opcional
            'is_available' => 'required|boolean',
            // 'restaurant_id' => 'required|exists:restaurants,id' // Si aplica
        ]);

        Table::create($validatedData);

        return redirect()->route('admin.tables.index')
                         ->with('success', 'Mesa creada exitosamente.');
    }

    /**
     * Muestra los detalles de una mesa específica (opcional, podría no ser necesario).
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\View\View
     */
    public function show(Table $table)
    {
        // Generalmente, los detalles son visibles en el index o edit.
        // Pero si se necesita una vista dedicada:
        // return view('admin.tables.show', compact('table'));
         return redirect()->route('admin.tables.edit', $table); // Redirigir a editar es común
    }

    /**
     * Muestra el formulario para editar una mesa existente.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\View\View
     */
    public function edit(Table $table)
    {
         // Cargar datos relacionados si es necesario (ej. Restaurantes)
        return view('admin.tables.edit', compact('table'));
    }

    /**
     * Actualiza una mesa específica en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Table $table)
    {
        $validatedData = $request->validate([
            // Permitir que el nombre sea el mismo para el registro actual
            'name' => 'required|string|max:255|unique:tables,name,' . $table->id,
            'capacity' => 'required|integer|min:1',
            'location_description' => 'nullable|string|max:255',
            'is_available' => 'required|boolean',
             // 'restaurant_id' => 'required|exists:restaurants,id' // Si aplica
        ]);

        $table->update($validatedData);

        return redirect()->route('admin.tables.index')
                         ->with('success', 'Mesa actualizada exitosamente.');
    }

    /**
     * Elimina una mesa específica de la base de datos.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Table $table)
    {
        // Considerar qué pasa si la mesa tiene reservas asociadas.
        // ¿Prevenir eliminación? ¿Eliminar en cascada? (Definir en la migración/modelo)
        // if ($table->reservations()->count() > 0) {
        //     return back()->with('error', 'No se puede eliminar la mesa porque tiene reservas asociadas.');
        // }

        try {
            $table->delete();
            return redirect()->route('admin.tables.index')
                             ->with('success', 'Mesa eliminada exitosamente.');
        } catch (\Exception $e) {
             // Log::error(...)
            return redirect()->route('admin.tables.index')
                             ->with('error', 'Error al eliminar la mesa.');
        }
    }
}