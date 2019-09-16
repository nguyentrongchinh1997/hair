<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_id')->comment('id dịch vụ');
            $table->integer('customer_id')->comment('id khách hàng');
            $table->integer('card_id')->comment('id thẻ');
            $table->float('percent')->comment('% chiết khấu dịch vụ');
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
        Schema::dropIfExists('card_details');
    }
}
