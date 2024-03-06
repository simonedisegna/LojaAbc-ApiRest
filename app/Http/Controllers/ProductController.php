<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Alterado para a namespace correta

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }
}

