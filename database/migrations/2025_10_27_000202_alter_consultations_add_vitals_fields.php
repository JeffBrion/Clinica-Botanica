<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->boolean('is_chronic')->default(false)->after('consultation_type');
            $table->decimal('weight', 6, 2)->nullable()->after('is_chronic'); // kg
            $table->string('blood_pressure')->nullable()->after('weight'); // ej: 120/80
            $table->unsignedInteger('heart_rate')->nullable()->after('blood_pressure'); // bpm

            // Remover campo de observaciones, reemplazado por campos específicos
            $table->dropColumn('observations');
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->text('observations')->nullable();
            $table->dropColumn(['is_chronic', 'weight', 'blood_pressure', 'heart_rate']);
        });
    }
};
