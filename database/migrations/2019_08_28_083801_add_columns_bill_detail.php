<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsBillDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bill_detail', function (Blueprint $table) {
            $table->string('other_service')->nullable()->comment('Tên dịch vụ khác nếu có');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bill_detail', function (Blueprint $table) {
            $table->dropColumn('other_service');
        });
    }
}
