<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;
use App\Http\Controllers\ValidationException;



class SaleController extends Controller
{
    public function index(){
        return Sale::all();
    }

    // Método para cadastrar uma nova venda
    public function createSale(Request $request){
    try {
        // Validação dos dados
        $request->validate([
            'id' => 'required|unique:sales',
            'id_sales' => 'required', // Ajuste conforme necessário, dependendo do relacionamento
            'total_amount' => 'required|numeric|min:0',
            'products' => 'required|array',
            'products.*.product_id' => [
                'required',
                Rule::exists('products', 'id')
            ],
            'products.*.amount' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        // Cálculo do total_amount
        $totalAmount = 0;
        foreach ($request->input('products') as $productData) {
            $totalAmount += $productData['amount'] * $productData['price'];
        }

        // Início da transação
        DB::beginTransaction();

        // Criação da venda
        $sale = Sale::create([
            'id' => $request->input('id'), // Autocomplete
            'id_sales' => $request->input('id_sales'),
            'total_amount' => $totalAmount
        ]);

        // Registro dos produtos vendidos
        foreach ($request->input('products') as $productData) {
            SaleProduct::create([
                'sale_id' => $sale->id,
                'product_id' => $productData['product_id'],
                'quantity' => $productData['amount'],
                'price' => $productData['price']
            ]);
        }

        // Commit da transação
        DB::commit();

        // Retorno da resposta JSON
        $saleDetails = [
            'id' => $sale->id,
            'id_sales' => $sale->id_sales,
            'total_amount' => $sale->total_amount,
            'products' => $request->input('products')
        ];

        return response()->json(['message' => 'Venda cadastrada com sucesso', 'data' => $saleDetails]);
    } catch (\Exception $e) {
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        // Reversão da transação e retorno da mensagem de erro
        DB::rollBack();
        return response()->json(['error' => 'Erro ao cadastrar a venda: ' . $e->getMessage()], 500);
    }
}

    // Método para listar vendas realizadas
    public function listSales()
    {
        // Recupere todas as vendas com seus produtos associados
        $sales = Sale::with('saleProducts.product')->get();

        // Montar o JSON com os detalhes da venda e dos produtos
        $formattedSales = $sales->map(function ($sale) {
            return [
                'sales_id' => $sale->sales_id,
                'amount' => $sale->total_amount,
                'products' => $sale->saleProducts->map(function ($saleProduct) {
                    return [
                        'product_id' => $saleProduct->product_id,
                        'nome' => $saleProduct->product->name,
                        'price' => $saleProduct->price,
                        'amount' => $saleProduct->quantity
                    ];
                })
            ];
        });

        // Retornar a resposta JSON
        return response()->json($formattedSales);
    }

    //Listar venda disponivel
    public function getSale($id)
    {
        try {
            // Tente encontrar a venda pelo ID
            $sale = Sale::with('saleProducts.product')->findOrFail($id);
    
            // Formate os detalhes da venda
            $formattedSale = [
                'sales_id' => $sale->sales_id,
                'amount' => $sale->total_amount,
                'products' => $sale->saleProducts->map(function ($saleProduct) {
                    return [
                        'product_id' => $saleProduct->product_id,
                        'nome' => $saleProduct->product->name,
                        'price' => $saleProduct->price,
                        'amount' => $saleProduct->quantity
                    ];
                })
            ];
    
            // Retorne os detalhes da venda formatados em formato JSON
            return response()->json($formattedSale);
        } catch (ModelNotFoundException $e) {
            // Se a venda não for encontrada, retorne uma resposta indicando isso
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }
    }

    // Método para consultar uma venda específica
    public function showSale($id)
    {
        $sale = Sale::findOrFail($id);
        return response()->json($sale);
    }

    // Método para cancelar uma venda
    public function cancelSale($id)
    {
        try {
            // Encontre a venda pelo ID
            $sale = Sale::findOrFail($id);

            // Encontre e exclua os produtos associados a esta venda na tabela sale_products
            $sale->saleProducts()->delete();

            // Agora você pode excluir a venda
            $sale->delete();

            // Retorne uma resposta JSON informando que a venda e seus produtos foram excluídos com sucesso
            return response()->json(['message' => 'Venda e produtos associados excluídos com sucesso']);
        } catch (ModelNotFoundException $e) {
            // Se a venda não for encontrada, retorne uma resposta indicando isso
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }
    }

    // Método para cadastrar novos produtos a uma venda existente
    public function addProductsToSale(Request $request, $id)
    {
        // Valide os dados recebidos do request
        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        // Encontre a venda existente
        $sale = Sale::findOrFail($id);

        // Registre os novos produtos vendidos
        foreach ($request->input('products') as $productData) {
            SaleProduct::create([
                'sale_id' => $sale->id,
                'product_id' => $productData['product_id'],
                'quantity' => $productData['quantity'],
                'price' => $productData['price']
            ]);
        }

        // Atualize o valor total da venda
        $sale->update([
            'total_amount' => $sale->total_amount + $request->input('total_amount')
        ]);

        return response()->json(['message' => 'Produtos adicionados com sucesso à venda']);
    }
}
