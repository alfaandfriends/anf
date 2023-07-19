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
        Schema::create('product_second_variations', function (Blueprint $table) {
            $table->id();
            $table->string('variation', 50)->nullable();
            $table->string('option', 50)->nullable();
            $table->bigInteger('price')->nullable();
            $table->integer('stock')->nullable();
            $table->string('sku')->nullable();
            $table->integer('sales')->default(0);
            $table->unsignedBigInteger('product_variation_id')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('product_second_variations');
    }
};
