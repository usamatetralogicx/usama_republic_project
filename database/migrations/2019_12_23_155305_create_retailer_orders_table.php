<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetailerOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailer_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('retailer_id');
            $table->string('shopify_order_id')->nullable();
            $table->string('email')->nullable();
            $table->string('full_name')->nullable();
            $table->longText('line_items')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->dateTime('shopify_created_at')->nullable();
            $table->dateTime('shopify_updated_at')->nullable();
            $table->integer('number')->nullable();
            $table->text('note')->nullable();
            $table->string('token')->nullable();
            $table->string('gateway')->nullable();
            $table->string('total_price')->nullable();
            $table->string('subtotal_price')->nullable();
            $table->string('total_weight')->nullable();
            $table->string('total_tax')->nullable();
            $table->boolean('taxes_included')->nullable();
            $table->string('financial_status')->nullable();
            $table->boolean('confirmed')->nullable();
            $table->string('currency')->nullable();
            $table->string('total_discounts')->nullable();
            $table->string('total_line_items_price')->nullable();
            $table->string('buyer_accepts_marketing')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->string('name')->nullable();
            $table->string('referring_site')->nullable();
            $table->string('landing_site')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->string('total_price_usd')->nullable();
            $table->string('user_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('app_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('payment_gateway_names')->nullable();
            $table->string('fulfillment_status')->nullable();
            $table->longText('fulfillments')->nullable();
            $table->string('processing_method')->nullable();
            $table->longText('tax_lines')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('order_status_url')->nullable();
            $table->text('total_line_items_price_set')->nullable();
            $table->text('total_price_set')->nullable();
            $table->text('shipping_lines')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->text('customer')->nullable();
            $table->boolean('sync_status')->default(false)->nullable();
            $table->boolean('send_to_supplier')->default(false)->nullable();


            $table->timestamps();

//            $table->foreign('retailer_id')
//                ->references('id')
//                ->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retailer_orders');
    }
}
