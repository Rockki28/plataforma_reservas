<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Puedes importar modelos si necesitas mostrar datos en la página de inicio,
// por ejemplo, información general del restaurante.
// use App\Models\Restaurant;

class HomeController extends Controller
{
    /**
     * Muestra la página de inicio del sitio web.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Aquí podrías cargar datos adicionales si fueran necesarios para la 'welcome page'
        // $restaurantInfo = Restaurant::first(); // Ejemplo
        // return view('welcome', compact('restaurantInfo'));

        // Devuelve la vista principal 'welcome'
        return view('welcome');
    }
}