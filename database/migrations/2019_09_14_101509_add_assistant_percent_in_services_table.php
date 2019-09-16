<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssistantPercentInServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->float('percent',15, 2)->comment('% cho thợ chính')->change();
            $table->float('assistant_percent', 15, 2)->comment('% cho thợ phụ')->after('percent');
            $table->float('main_request_percent', 15, 2)->comment('% cho thợ chính yêu cầu')->after('assistant_percent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->float('percent',15, 2)->comment('% cho thợ chính')->change();
            $table->dropColumn('assistant_percent');
            $table->dropColumn('main_request_percent');
        });
    }
}
