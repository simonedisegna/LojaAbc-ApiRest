<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\SaleProduct;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Incluir dados na tabela 'sales'
        $sale = Sale::create([
            'sales_id' => '202301011',
            'total_amount' => 5000,
        ]);

        // Incluir dados na tabela 'sale_products'
        $products = [
            [
                'product_id' => 1,
                'nome' => 'Celular 1',
                'price' => 1800,
                'amount' => 1
            ],
            [
                'product_id' => 2,
                'nome' => 'Celular 2',
                'price' => 3200,
                'amount' => 1
            ],
        ];

        foreach ($products as $product) {
            SaleProduct::create([
                'sale_id' => $sale->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['amount'],
                'price' => $product['price']
            ]);
        }
    }
}
