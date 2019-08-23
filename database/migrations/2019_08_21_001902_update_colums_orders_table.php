<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('service_id')->comment('id dịch vụ');
            $table->integer('time_id')->comment('id thời gian khách đặt');
            $table->date('date')->change()->comment('ngày tháng năm đặt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('service_id');
            $table->integer('time_id')->comment('id thời gian khách đặt');
        });
    }
}
