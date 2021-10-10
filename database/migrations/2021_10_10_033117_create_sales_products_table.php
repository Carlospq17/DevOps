<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_products', function (Blueprint $table) {   
            $table->id();

            $table->foreignId('sales_id')
                ->references('id')
                ->on('sales')->onDelete('cascade');

            $table->foreignId('products_id')
                ->references('id')
                ->on('products')->onDelete('cascade');

            $table->float('amount', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_products');
    }
}
