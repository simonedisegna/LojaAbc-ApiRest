<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sale_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            // Chave estrangeira para a tabela sales
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');

            // Chave estrangeira para a tabela products
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      //  Schema::dropIfExists('sale_products');
    }
};
