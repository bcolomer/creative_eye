<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('producto_id');
            $table->string('nombre');
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2);
            $table->string('codigo')->unique();
            $table->string('foto')->nullable();
            $table->text('descripcion')->nullable();
            // Para SET NULL la columna debe ser nullable:
            $table->foreignId('categoria_id')
                ->nullable()
                ->constrained('categorias', 'categoria_id')
                ->nullOnDelete(); // equivalente a ON DELETE SET NULL
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
