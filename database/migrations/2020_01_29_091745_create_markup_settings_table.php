<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkupSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markup_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('value')->nullable();
            $table->string('type')->nullable();
            $table->boolean('ask_every_time')->nullable();

            /**
             * Metadata of table fields
             *
             * value stores the actual numeric value
             *
             * type can have one of these 4 values
             *
             * 0 (not setting any rule),
             * 1 (percentage),
             * 2 (fixed),
             * 3 (multiplier)
             *
             * ask_every_time can have two values
             *
             * true (in case retailer want to be asked about price every time he adds product to import-list)
             * false (in case retailer want to use the prices defined in settings on every product import)
             **/

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
        Schema::dropIfExists('markup_settings');
    }
}
