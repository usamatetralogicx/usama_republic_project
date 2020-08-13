<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->string('shopify_image_id')->nullable(); //coming from shopify
            $table->boolean('isVariant')->nullable(); //true if image is of variant, false for product level images
            $table->text('alt')->nullable();
            $table->integer('position')->nullable();
            $table->integer('height')->nullable();
            $table->integer('width')->nullable();
            $table->text('src')->nullable();
            $table->text('variants_ids')->nullable();

            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_images');
    }
}
