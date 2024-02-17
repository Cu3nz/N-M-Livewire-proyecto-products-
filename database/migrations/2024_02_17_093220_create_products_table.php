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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table -> string('nombre') -> unique();
            $table -> text('descripcion');
            $table -> integer('stock');
            $table -> enum('disponible' , ['SI' , 'NO']);
            $table -> string('imagen');
            $table -> float('pvp' , 6,2); //? Maximo 9999.99
            $table -> foreignId('user_id') -> constrained() -> cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
