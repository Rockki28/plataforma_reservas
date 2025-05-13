<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Table extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'restaurant_id', // Clave foránea para la relación con Restaurant
        'name',
        'capacity',
        'location_description',
        'is_available',
    ];

    /**
     * The attributes that should be cast.
     * Convierte automáticamente el atributo 'is_available' a booleano.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_available' => 'boolean',
    ];

    /**
     * Get the restaurant that owns the table.
     * Define la relación inversa de uno a muchos: Una mesa pertenece a un restaurante.
     */
    public function restaurant(): BelongsTo
    {
        // El segundo argumento (nombre de la relación) y el tercero (clave foránea)
        // son opcionales si sigues las convenciones (método 'restaurant' y clave foránea 'restaurant_id').
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get the reservations for the table.
     * Define la relación uno a muchos: Una mesa puede tener muchas reservas.
     */
    public function reservations(): HasMany
    {
        // Asume la clave foránea 'table_id' en la tabla 'reservations'.
        return $this->hasMany(Reservation::class);
    }
}