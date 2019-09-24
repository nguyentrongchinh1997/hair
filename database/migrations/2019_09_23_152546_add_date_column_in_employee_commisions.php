<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateColumnInEmployeeCommisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_commisions', function (Blueprint $table) {
            $date = date('Y-m-d');
            $table->date('date')->after('percent')->default($date);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_commisions', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }
}
