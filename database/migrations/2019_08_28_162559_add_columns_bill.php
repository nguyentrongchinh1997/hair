<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsBill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->integer('rate_status')->after('status')->comment('1=mới nhất, 0 = cũ')->default(0);
            $table->string('rate')->change()->comment('đánh giá của khách hàng');
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
            $table->dropColumn('rate_status');
            $table->string('rate')->comment('đánh giá của khách hàng');
        });
    }
}
