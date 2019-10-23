<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleClassDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_class_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vehicle_class_id');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**es
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_class_details');
    }
}
