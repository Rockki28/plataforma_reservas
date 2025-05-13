<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
                  ->constrained('clients')
                  ->onDelete('cascade');
            $table->foreignId('table_id')
                  ->constrained('tables')
                  ->onDelete('cascade');
            $table->foreignId('restaurant_id') // Asumiendo que una reserva también se vincula directamente a un restaurante
                  ->constrained('restaurants')
                  ->onDelete('cascade');
            $table->timestamp('reservation_datetime');
            $table->integer('number_of_guests');
            $table->string('status')->nullable()->comment("Ej: pending, confirmed, cancelled, completed"); // Añadí un comentario como ejemplo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};