<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetailerProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailer_product_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('retailer_product_id')->nullable();
            $table->text('name')->nullable();
            $table->integer('position')->nullable();
            $table->text('values')->nullable();
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
        Schema::dropIfExists('retailer_product_options');
    }
}
