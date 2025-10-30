<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('security');
    }

    public function down(): void
    {
        Schema::create('security', function (Blueprint $table) {
            $table->id('security_id');
            $table->unsignedBigInteger('usuario_id');
            $table->string('password');
            $table->timestamps();

            $table->foreign('usuario_id')->references('usuario_id')->on('usuarios')->onDelete('cascade');
        });
    }
};
