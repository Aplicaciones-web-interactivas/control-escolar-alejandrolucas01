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
        if (!Schema::hasTable('entregas')) {
            Schema::create('entregas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('actividad_id')->constrained('actividades')->onDelete('cascade');
                $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
                $table->string('ruta_archivo');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entregas');
    }
};
