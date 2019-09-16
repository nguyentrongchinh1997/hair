<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeCommisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_commisions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->comment('id nhân viên');
            $table->integer('bill_detail_id')->comment('id chi tiết hóa đơn');
            $table->float('percent')->comment('% được hưởng');
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
        Schema::dropIfExists('employee_commisions');
    }
}
