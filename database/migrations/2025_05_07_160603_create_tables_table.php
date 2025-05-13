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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')
                  ->constrained('restaurants') // Asume que la tabla es 'restaurants' y la PK es 'id'
                  ->onDelete('cascade');    // Si se elimina un restaurante, se eliminan sus mesas
            $table->string('name')->nullable();
            $table->integer('capacity');
            $table->string('location_description')->nullable();
            $table->boolean('is_available')->default(true);
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
        Schema::dropIfExists('tables');
    }
};