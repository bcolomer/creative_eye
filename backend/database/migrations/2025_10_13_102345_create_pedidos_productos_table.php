<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pedidos_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos', 'pedido_id')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos', 'producto_id')->cascadeOnDelete();
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('precio_total', 10, 2);
            $table->timestamps();

            // (Opcional) Evitar duplicados del mismo producto en el mismo pedido:
            // $table->unique(['pedido_id', 'producto_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pedidos_productos');
    }
};
