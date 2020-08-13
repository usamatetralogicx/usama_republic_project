<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetailerProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailer_product_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('retailer_product_id')->nullable();
            $table->unsignedBigInteger('retailer_product_image_id')->nullable(); // linked with local
            $table->string('shopify_image_id')->nullable(); // id came back from shopify
//            $table->string('local_shopify_image_id')->nullable(); // id came back from shopify
            $table->string('shopify_variant_id')->nullable(); //variant id came back from shopify
            $table->string('local_shopify_variant_id')->nullable();
            $table->text('title')->nullable();
            $table->string('sku')->nullable();
            $table->string('option1')->nullable();
            $table->string('option2')->nullable();
            $table->string('option3')->nullable();
            $table->string('quantity')->nullable();
            $table->integer('grams')->nullable();
            $table->string('weight')->nullable();
            $table->string('weight_unit')->nullable();
            $table->string('barcode')->nullable();
            $table->string('cost')->nullable();
            $table->string('price')->nullable();
            $table->text('src')->nullable();
            $table->timestamps();

            $table->foreign('retailer_product_id')
                ->references('id')
                ->on('retailer_products');

            $table->foreign('retailer_product_image_id')
                ->references('id')
                ->on('retailer_product_images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retailer_product_variants');
    }
}
