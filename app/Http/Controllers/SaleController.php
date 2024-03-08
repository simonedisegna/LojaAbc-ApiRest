<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class SaleController extends Controller
{
    // Método para cadastrar uma nova venda
    public function createSale(Request $request)
    {
        // Valide os dados recebidos do request
        $request->validate([
            'sales_id' => 'required|unique:sales',
            'total_amount' => 'required|numeric|min:0',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        try {
            // Inicie uma transação de banco de dados
            DB::beginTransaction();

            // Crie a venda
            $sale = Sale::create([
                'sales_id' => $request->input('sales_id'),
                'total_amount' => $request->input('total_amount')
            ]);

            // Registre os produtos vendidos
            foreach ($request->input('products') as $productData) {
                SaleProduct::create([
                    'sale_id' => $sale->id,
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                    'price' => $productData['price']
                ]);
            }

            // Commit da transação
            DB::commit();

            // Retorne uma resposta JSON com os detalhes da venda e dos produtos vendidos
            $saleDetails = [
                'sales_id' => $sale->id, // Corrigido para usar o ID da venda recém-criada
                'total_amount' => $sale->total_amount,
                'products' => $request->input('products')
            ];
            
            // Retorne uma resposta JSON indicando que a venda foi cadastrada com sucesso
            return response()->json(['message' => 'Venda cadastrada com sucesso', 'data' => $saleDetails]);
        } catch (\Exception $e) {
            // Se ocorrer algum erro, reverta a transação e retorne uma resposta de erro
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
        // Encontre a venda pelo ID
        $sale = Sale::findOrFail($id);

        // Encontre e exclua os produtos associados a esta venda na tabela sale_products
        $sale->saleProducts()->delete();

        // Agora você pode excluir a venda
        $sale->delete();

        // Retorne uma resposta JSON informando que a venda e seus produtos foram excluídos com sucesso
        return response()->json(['message' => 'Venda e produtos associados excluídos com sucesso']);
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
