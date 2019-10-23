<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageUrlToEateryMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eatery_menus', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eatery_menus', function (Blueprint $table) {
            if (Schema::hasColumn('eatery_menus', 'image_url'));
            {
                $table->dropColumn('image_url');
            }
        });
    }
}
