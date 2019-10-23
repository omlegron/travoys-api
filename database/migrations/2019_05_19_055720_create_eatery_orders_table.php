<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEateryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eatery_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->integer('user_id');
            $table->integer('eatery_id');
            $table->enum('status', ['pre-order', 'ordered', 'ready', 'paid', 'canceled']);
            $table->dateTime('paid_date')->nullable();
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
        Schema::dropIfExists('eatery_orders');
    }
}
