<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Sale;
use App\Models\SaleProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaleRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_have_multiple_sale_products()
    {
        // Criar uma venda
        $sale = Sale::factory()->create();

        // Criar produtos de venda associados
        $saleProduct1 = SaleProduct::factory()->create(['sale_id' => $sale->id]);
        $saleProduct2 = SaleProduct::factory()->create(['sale_id' => $sale->id]);

        // Verificar se os produtos de venda estão associados corretamente
        $this->assertEquals(2, $sale->saleProducts->count());
        $this->assertTrue($sale->saleProducts->contains($saleProduct1));
        $this->assertTrue($sale->saleProducts->contains($saleProduct2));
    }

     /** @test */
     public function it_belongs_to_a_sale()
     {
         // Criar uma venda
         $sale = Sale::factory()->create();
 
         // Criar um produto de venda
         $saleProduct = SaleProduct::factory()->create(['sale_id' => $sale->id]);
 
         // Verificar se o produto de venda pertence à venda correta
         $this->assertEquals($sale->id, $saleProduct->sale->id);
     }
 }
    

?>