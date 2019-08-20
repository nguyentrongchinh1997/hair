<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rate')->nullable()->comment('đánh giá của khách hàng');
            $table->integer('customer_id')->comment('id khách hàng');
            $table->float('total', 15, 2)->comment('Tổng giá');
            $table->integer('sale')->default(0)->comment('phần trăm sale nếu có');
            $table->string('sale_detail')->comment('Chi tiết sale');
            $table->string('comment')->comment('bình luận riêng của khách hàng');
            $table->dateTime('time')->comment('thời gian');
            $table->integer('status')->default(0)->comment('trạng thái hóa đơn');
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
        Schema::dropIfExists('bills');
    }
}
