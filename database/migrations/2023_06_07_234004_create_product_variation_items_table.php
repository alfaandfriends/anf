<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variation_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_variation_id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name', 50);
            $table->bigInteger('price');
            $table->integer('stock');
            $table->string('sku');
            $table->integer('sales')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('product_variation_id')->references('id')->on('product_variations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variation_items');
    }
};
