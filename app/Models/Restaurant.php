<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'description',
        // Agrega aquí otros campos relevantes para el restaurante
    ];

    /**
     * Get the tables associated with the restaurant.
     * Define la relación uno a muchos: Un restaurante tiene muchas mesas.
     */
    public function tables(): HasMany
    {
        // El segundo argumento (clave foránea) y el tercero (clave local)
        // son opcionales si sigues las convenciones de Laravel (restaurant_id en la tabla tables).
        return $this->hasMany(Table::class);
    }

    /**
     * Get the reservations associated with the restaurant.
     * Define la relación uno a muchos: Un restaurante tiene muchas reservas.
     * Nota: Esta relación asume que tienes una columna 'restaurant_id' en tu tabla 'reservations'.
     * Si las reservas solo se vinculan a través de las mesas, podrías usar hasManyThrough.
     * hasManyThrough(Reservation::class, Table::class)
     */
    public function reservations(): HasMany
    {
        // Asume que existe 'restaurant_id' en la tabla 'reservations'.
        return $this->hasMany(Reservation::class);
    }
}