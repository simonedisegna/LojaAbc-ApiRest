<?php
    // tests/Feature/ProductTest.php

    namespace Tests\Feature;

    use App\Models\Product;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Foundation\Testing\WithFaker;
    use Tests\TestCase;

    class ProductTest extends TestCase
    {
        use RefreshDatabase;

        public function test_can_create_product()
        {
            $product = Product::factory()->create([
                'name' => 'Celular 1',
                'price' => 1000,
                'description' => 'Descrição do celular',
            ]);

            $this->assertDatabaseHas('products', [
                'name' => 'Celular 1',
                'price' => 1000,
                'description' => 'Descrição do celular',
            ]);
        }

    }

?>