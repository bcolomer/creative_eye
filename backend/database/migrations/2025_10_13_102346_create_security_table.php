<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('security', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->unique()->constrained(table: 'usuarios', column: 'usuario_id')->cascadeOnDelete();
            $table->string('password');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('security');
    }
};
