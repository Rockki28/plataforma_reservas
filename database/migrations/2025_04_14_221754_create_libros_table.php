<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        //Schema::create('libros', function (Blueprint $table) {
          //  $table->id();
           // $table->string('nombre'); //nombre del libro
           // $table->string('imagen'); //imagen del libro
           // $table->string('archivo'); //archivo pdf
           // $table->timestamps(); //tiempo de creacion y actualizacion
       // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('libros');
    }
};
