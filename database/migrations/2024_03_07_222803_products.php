<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->integer('amount');
            $table->timestamps();
        });

        // Insira os dados na tabela products
        $products = [
            [
                'name' => 'Celular 1',
                'price' => 1800,
                'amount' => 1
            ],
            [
                'name' => 'Celular 2',
                'price' => 3200,
                'amount' => 2
            ]
        ];

        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
