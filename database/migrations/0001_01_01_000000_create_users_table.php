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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('Usuario');
            $table->string('inss')->nullable();
            $table->string('worker_type')->nullable();
            $table->string('cargo')->nullable();
            $table->string('direccion')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->date('entry_date')->nullable();
            $table->string('contract_type')->nullable();

            $table->rememberToken();
            $table->nullableUserStamps();
            $table->timestamps();
        });

        Schema::create('modules', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('internal_name')->nullable();
            $table->string('access_route_name')->nullable();
            $table->string('icon')->nullable();

            $table->nullableUserStamps();
            $table->timestamps();
        });

        Schema::create('users_modules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('module_id')->constrained('modules')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->nullableUserStamps();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
        Schema::dropIfExists('users');
        Schema::dropIfExists('users_modules');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
