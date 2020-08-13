<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('image_id')->nullable(); // linked with local
            $table->string('shopify_image_id')->nullable(); // id coming from shopify
            $table->string('shopify_variant_id')->nullable(); //variant id from shopify
            $table->string('local_shopify_variant_id')->nullable(); //variant id from shopify
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

            $table->foreign('product_id')
                ->references('id')
                ->on('products');

            $table->foreign('image_id')
                ->references('id')
                ->on('product_images');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}
