<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Celular 1',
            'price' => 1800,
            'description' => 'Lorenzo Ipsulum'
        ]);

        Product::create([
            'name' => 'Celular 2',
            'price' => 3200,
            'description' => 'Lorem ipsum dolor'
        ]);

        Product::create([
            'name' => 'Celular 3',
            'price' => 9800,
            'description' => 'Lorem ipsum dolor sit amet'
        ]);
    }
}
?>