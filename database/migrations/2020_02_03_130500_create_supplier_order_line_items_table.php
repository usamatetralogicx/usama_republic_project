<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierOrderLineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_order_line_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('supplier_order_id')->nullable(); //link line item with order
            $table->unsignedBigInteger('retailer_product_variant_id')->nullable(); //link with retailer product variant
            $table->string('shopify_line_item_id')->nullable();
            $table->string('shopify_product_id')->nullable();
            $table->string('shopify_variant_id')->nullable();
            $table->text('title')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('fulfilled_quantity')->nullable();
            $table->string('variant_title')->nullable();
            $table->string('sku')->nullable();
            $table->string('vendor')->nullable();
            $table->string('fulfillment_service')->nullable();
            $table->string('requires_shipping')->nullable();
            $table->boolean('taxable')->nullable();
            $table->boolean('gift_card')->nullable();
            $table->string('name')->nullable();
            $table->text('properties')->nullable();
            $table->integer('fulfillable_quantity')->nullable();
            $table->string('price')->nullable();
            $table->string('fulfillment_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_order_line_items');
    }
}
