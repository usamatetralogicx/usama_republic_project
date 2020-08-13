<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailerProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailer_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('retailer_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('shopify_product_id')->nullable();
            $table->text('title');
            $table->longText('body_html')->nullable();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->string('vendor')->nullable();
            $table->string('grams')->nullable();
            $table->string('type')->nullable();
            $table->text('tags')->nullable();
            $table->string('option1')->nullable();
            $table->text('value1')->nullable();
            $table->string('option2')->nullable();
            $table->text('value2')->nullable();
            $table->string('option3')->nullable();
            $table->text('value3')->nullable();
            $table->text('image')->nullable();
            $table->string('shop_id')->nullable();
            $table->integer('price')->nullable(); //
            $table->integer('cost')->nullable(); // price coming from products table
            $table->text('handle')->nullable();
            $table->boolean('status')->nullable(); // true for active , false for inactive
            $table->boolean('toShopify')->nullable(); //true for exported to shopify products , false for products in drafts

            $table->timestamps();

            $table->foreign('retailer_id')
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
        Schema::dropIfExists('retailer_products');
    }
}
