<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',        // Clave foránea para la relación con Client
        'table_id',         // Clave foránea para la relación con Table
        'restaurant_id',    // Clave foránea para la relación con Restaurant (si aplica directamente)
        'reservation_datetime',
        'number_of_guests',
        'status', // Ej: 'pending', 'confirmed', 'cancelled', 'completed'
        // Agrega aquí cualquier otro campo relevante para la reserva
    ];

    /**
     * The attributes that should be cast.
     * Convierte la fecha/hora de reserva a un objeto Carbon para fácil manipulación.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'reservation_datetime' => 'datetime',
        'number_of_guests' => 'integer',
    ];

    /**
     * Get the client that made the reservation.
     * Define la relación inversa: Una reserva pertenece a un cliente.
     */
    public function client(): BelongsTo
    {
        // Asume la clave foránea 'client_id'.
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the table for which the reservation was made.
     * Define la relación inversa: Una reserva pertenece a una mesa.
     */
    public function table(): BelongsTo
    {
        // Asume la clave foránea 'table_id'.
        return $this->belongsTo(Table::class);
    }

    /**
     * Get the restaurant associated with the reservation.
     * Define la relación inversa: Una reserva pertenece a un restaurante.
     * (Si la relación es directa mediante 'restaurant_id' en la tabla reservations)
     */
    public function restaurant(): BelongsTo
    {
        // Asume la clave foránea 'restaurant_id'.
        return $this->belongsTo(Restaurant::class);
    }
}