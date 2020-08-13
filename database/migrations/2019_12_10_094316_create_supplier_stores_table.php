<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_stores', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('shop_domain')->nullable();
            $table->string('api_key')->nullable();
            $table->string('password')->nullable();
            $table->string('shared_secret')->nullable();
            $table->integer('fetch_count')->default(0)->nullable();
            $table->string('profit_margin_percentage')->default('0')->nullable();
            $table->string('profit_margin_fixed')->default('0')->nullable();

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
        Schema::dropIfExists('supplier_stores');
    }
}
