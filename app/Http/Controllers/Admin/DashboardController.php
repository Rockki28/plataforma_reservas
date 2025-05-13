<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation; // Para contar reservas, por ejemplo
use App\Models\Table;       // Para contar mesas
use App\Models\Client;      // Para contar clientes

class DashboardController extends Controller
{
    /**
     * Muestra el panel principal de administración.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Cargar datos resumidos para el dashboard
        $totalReservations = Reservation::count();
        $totalTables = Table::count();
        $totalClients = Client::count();
        // Puedes añadir más estadísticas (ej. reservas de hoy, mesas disponibles, etc.)

        return view('admin.dashboard', compact(
            'totalReservations',
            'totalTables',
            'totalClients'
        ));
    }
}
