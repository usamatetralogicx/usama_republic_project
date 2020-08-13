<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetailerProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailer_product_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('retailer_product_id')->nullable(); //id to link it with retailer product
            $table->unsignedBigInteger('retailer_product_variant_id')->nullable(); //id to link it with retailer product variant
            $table->string( 'shopify_image_id')->nullable(); //id to link it with retailer
            $table->boolean('isVariant')->nullable(); //true if image is of variant, false for product level images
            $table->text('alt')->nullable();
            $table->integer('position')->nullable();
            $table->integer('height')->nullable();
            $table->integer('width')->nullable();
            $table->text('src')->nullable();
            $table->text('variant_ids')->nullable();

            $table->timestamps();

            $table->foreign('retailer_product_id')
                ->references('id')
                ->on('retailer_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retailer_product_images');
    }
}
