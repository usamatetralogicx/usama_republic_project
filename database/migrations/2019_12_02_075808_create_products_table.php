<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('shopify_product_id')->nullable(); //id coming from shopify
            $table->text('title');
            $table->longText('body_html')->nullable();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->string('vendor')->nullable();
            $table->string('grams')->nullable();
            $table->string('type')->nullable();
            $table->text('handle')->nullable();
            $table->text('tags')->nullable();
            $table->string('option1')->nullable();
            $table->text('value1')->nullable();
            $table->string('option2')->nullable();
            $table->text('value2')->nullable();
            $table->string('option3')->nullable();
            $table->text('value3')->nullable();
            $table->boolean('fromShopify')->nullable();
            $table->boolean('status')->default(true)->nullable(); // true for active , false for inactive
            $table->text('image')->nullable();
            $table->string('shop_id')->nullable();
            $table->integer('price')->nullable();
            $table->integer('cost')->nullable();
            $table->integer('sold_count')->default(0)->nullable(); //its tells how many time this product is added to import list
            $table->timestamps();


            $table->foreign('supplier_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
