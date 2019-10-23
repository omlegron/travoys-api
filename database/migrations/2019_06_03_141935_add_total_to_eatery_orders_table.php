<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalToEateryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eatery_orders', function (Blueprint $table) {
            $table->float('total')->default(0)->after('eatery_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eatery_orders', function (Blueprint $table) {
            if (Schema::hasColumn('eatery_orders', 'total'));
            {
                $table->dropColumn('total');
            }
        });
    }
}
