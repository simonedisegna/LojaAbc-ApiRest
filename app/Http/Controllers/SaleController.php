<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        $saleData = $request->all();
        $sale = Sale::create(['amount' => $saleData['amount']]);

        foreach ($saleData['products'] as $productData) {
            $saleItem = new SaleItem([
                'product_id' => $productData['product_id'],
                'amount' => $productData['amount']
            ]);
            $sale->items()->save($saleItem);
        }

        return response()->json($sale, 201);
    }
}

