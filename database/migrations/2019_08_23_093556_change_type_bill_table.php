<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->float('price', 15, 2)->after('total')->comment('giá dịch vụ sử dụng');
            $table->integer('order_id')->after('customer_id')->comment('id đơn ứng với hóa đơn');
            $table->float('total', 15, 2)->nullable()->change();
            $table->string('sale_detail')->nullable()->change();
            $table->string('comment')->nullable()->change();
            $table->dateTime('time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn('price');
            
        });
    }
}
