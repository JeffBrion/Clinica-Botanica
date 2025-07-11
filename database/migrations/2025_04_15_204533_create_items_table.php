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

        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('description')->nullable();

            $table->rememberToken();
            $table->nullableUserStamps();
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('code')->unique()->nullable();
            $table->string('description')->nullable();
            $table->foreignId('category_id')->constrained('categories');

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
        Schema::dropIfExists('categories');
        Schema::dropIfExists('items');
    }
};
