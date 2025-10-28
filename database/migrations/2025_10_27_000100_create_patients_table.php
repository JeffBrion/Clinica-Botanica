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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            // Datos básicos del paciente
            $table->string('name'); // Nombre completo o nombres
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable(); // M/F/O
            $table->date('birth_date')->nullable();

            // Contacto
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();

            // Otros
            $table->text('notes')->nullable();

            // Convenciones del proyecto
            $table->rememberToken();
            $table->nullableUserStamps();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
