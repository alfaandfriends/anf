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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('variation', 50)->nullable();
            $table->string('option', 50)->nullable();
            $table->bigInteger('price')->nullable();
            $table->integer('stock')->nullable();
            $table->string('sku')->nullable();
            $table->integer('sales')->default(0);
            $table->unsignedBigInteger('product_id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variations');
    }
};
