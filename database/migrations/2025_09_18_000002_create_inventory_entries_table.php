<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryEntriesTable extends Migration
{
    public function up()
    {
        Schema::create('inventory_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_product_id');
            $table->integer('quantity');
            $table->string('reason');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('supplier_product_id')->references('id')->on('supplier_products')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_entries');
    }
}
