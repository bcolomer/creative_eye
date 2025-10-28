<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('pedido_id');
            $table->foreignId('usuario_id')->constrained('usuarios', 'usuario_id')->cascadeOnDelete();
            $table->date('fecha_pedido');
            $table->decimal('total_pedido', 10, 2);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
