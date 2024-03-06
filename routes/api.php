<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Listar produtos disponíveis
Route::get('/products', [ProductController::class, 'index']);


// Cadastrar nova venda
Route::post('/sales', [SaleController::class, 'store']);
Route::post('/products', [ProductController::class, 'store']);

// Consultar vendas realizadas
Route::get('/sales', [SaleController::class, 'index']);

// Consultar uma venda específica
Route::get('/sales/{id}', [SaleController::class, 'show']);

// Cancelar uma venda (possível rota, mas não implementada no exemplo fornecido)
Route::delete('/sales/{id}', [SaleController::class, 'destroy']);

// Cadastrar novos produtos a uma venda (possível rota, mas não implementada no exemplo fornecido)
Route::post('/sales/{id}/add-products', [SaleController::class, 'addProducts']);
