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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();

            $table->decimal('precio', 10, 2)->default(0);

            // Si hay oferta, se marca true y puede tener precio_oferta.
            $table->boolean('oferta')->default(false);
            $table->decimal('precio_oferta', 10, 2)->nullable();

            // Imagen principal (puedes mantenerla como fallback)
            $table->string('imagen')->nullable();

            // ❌ Ya NO usamos categoria_id porque ahora es many-to-many con categoria_producto

            $table->boolean('activo')->default(true);

            $table->timestamps();
            $table->softDeletes(); // buena práctica para no perder historial
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
