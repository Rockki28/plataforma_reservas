<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        // Agrega aquí cualquier otro campo relevante para el cliente
    ];

    /**
     * Get the reservations made by the client.
     * Define la relación uno a muchos: Un cliente puede tener muchas reservas.
     */
    public function reservations(): HasMany
    {
        // Asume la clave foránea 'client_id' en la tabla 'reservations'.
        return $this->hasMany(Reservation::class);
    }
}