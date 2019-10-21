<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNumberColumnInMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->integer('number')->nullable()->comment('Số lần còn lại');
            $table->date('start_time')->nullable()->change();
            $table->date('end_time')->nullable()->change();
            $table->integer('status')->default(1)->comment('1 = còn hạn, 0 = hết hạn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropColumn(['number', 'status']);
        });
    }
}
