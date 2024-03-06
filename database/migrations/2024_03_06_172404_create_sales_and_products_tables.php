<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSalesAndProductsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /*  Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('sales_id')->default(202301011); // Adicione o campo com o valor padrão
        });

       Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('sales_id')->after('id'); // Adicione a coluna sales_id após a coluna id
            $table->string('nome')->after('sales_id'); // Adicione a coluna nome após a coluna sales_id
            $table->integer('price')->after('nome'); // Adicione a coluna price após a coluna nome
            $table->integer('amount')->after('price'); // Adicione a coluna amount após a coluna price
        });*/
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('amount')->after('id');
        });
        // Insira os dados de vendas e produtos
        $sales = [
            [
                'id' => '202301011',
                'amount' => 8200
            ]
        ];

        $products = [
            [
                'sales_id' => '202301011',
                'nome' => 'Celular 1',
                'price' => 1800,
                'amount' => 1
            ],
            [
                'sales_id' => '202301011',
                'nome' => 'Celular 2',
                'price' => 3200,
                'amount' => 2
            ]
        ];

        // Insira os dados na tabela sales
        foreach ($sales as $sale) {
            DB::table('sales')->insert($sale);
        }

        // Insira os dados na tabela products
        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('sales');
    }
}
?>