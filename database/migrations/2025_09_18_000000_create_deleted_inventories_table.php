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
        Schema::create('deleted_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_product_id')->constrained();
            $table->integer('quantity');
            $table->string('reason')->nullable();
            $table->foreignId('deleted_by')->constrained('users');
            $table->timestamp('deleted_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deleted_inventories');
    }
};
