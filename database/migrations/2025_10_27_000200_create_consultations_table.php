<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();

            // Relación opcional a patients y campo directo del nombre por compatibilidad con la vista
            $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->string('patient_name');

            $table->dateTime('consultation_date');
            $table->string('consultation_type'); // primera_vez, control, emergencia, seguimiento

            $table->text('symptoms');
            $table->text('observations')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();

            $table->rememberToken();
            $table->nullableUserStamps();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
