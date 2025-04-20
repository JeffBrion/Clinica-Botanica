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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('supplier_product_id')->constrained()->onDelete('cascade');
            $table->date('requested_date');
            $table->integer('quantity');
            $table->date('expiration_date');
            $table->string('status')->default('pending'); 
            
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
        Schema::dropIfExists('inventories');
    }
};
