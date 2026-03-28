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
        Schema::table('calificacions', function (Blueprint $table) {
            $table->decimal('parcial1', 4, 1)->default(0)->after('usuario_id');
            $table->decimal('parcial2', 4, 1)->default(0)->after('parcial1');
            $table->decimal('parcial3', 4, 1)->default(0)->after('parcial2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calificacions', function (Blueprint $table) {
            $table->dropColumn(['parcial1', 'parcial2', 'parcial3']);
        });
    }
};
