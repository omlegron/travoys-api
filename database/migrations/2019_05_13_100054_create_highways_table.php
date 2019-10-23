<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHighwaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('highways', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('start_latitude');
            $table->string('start_longitude');
            $table->string('end_latitude');
            $table->string('end_longitude');
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
        Schema::dropIfExists('highways');
    }
}
