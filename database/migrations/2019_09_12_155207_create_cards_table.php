<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->comment('id khách hàng');
            $table->string('card_name')->comment('tên thẻ');
            $table->float('price', 15, 2)->comment('chi phí thẻ');
            $table->date('start_time')->comment('thời gian bắt đầu làm thẻ');
            $table->date('end_time')->comment('thời gian kết thúc');
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
        Schema::dropIfExists('cards');
    }
}
