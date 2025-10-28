<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('usuario_id');
            $table->string('nombre');
            $table->string('nombre_usuario')->unique();
            $table->string('foto')->nullable();
            $table->foreignId('rol_id')->constrained('roles', column: 'rol_id')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
