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
            // Imagen principal (las vistas actuales usan 'imagen' como URL)
            $table->string('imagen')->nullable();
            // Relación con categorias (nullable para compatibilidad)
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->nullOnDelete();
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
