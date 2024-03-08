<?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\SaleController;


    // Consultar uma venda específica
    Route::get('/sales/{id}', [SaleController::class, 'show']);

    // Cadastrar nova venda
    Route::post('/sales', [SaleController::class, 'createSale']);

    // Consultar vendas realizadas
    Route::get('/sales', [SaleController::class, 'listSales']);

    // Consultar uma venda específica
    Route::get('/sales/{id}', [SaleController::class, 'showSale']);

    // Cancelar uma venda
    Route::delete('/sales/{id}', [SaleController::class, 'cancelSale']);

    // Cadastrar novos produtos a uma venda existente
    Route::post('/sales/{id}/add-products', [SaleController::class, 'addProductsToSale']);


    // Adicionar produtos a uma venda específica
    Route::post('/sales/{id}/add-products', [SaleController::class, 'addProducts']);

    // Listar produtos disponíveis
    Route::get('/products', [ProductController::class, 'index']);


    // Cadastrar novo produto
    Route::post('/products', [ProductController::class, 'store']);

?>