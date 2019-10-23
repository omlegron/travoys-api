<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEateryMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eatery_menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('eatery_id');
            $table->string('name');
            $table->float('price');
            $table->float('price_for_sell')->nullable();
            $table->float('stock')->nullable();
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
        Schema::dropIfExists('eatery_menus');
    }
}
