<?php
    // tests/Unit/SaleTest.php

    namespace Tests\Unit;

    use App\Models\Sale;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;

    class SaleTest extends TestCase
    {
        use RefreshDatabase;

        public function test_can_create_sale()
        {
            $sale = Sale::factory()->create();

            $this->assertInstanceOf(Sale::class, $sale);
            $this->assertDatabaseHas('sales', $sale->toArray());
        }
    }

    

?>