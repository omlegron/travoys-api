<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('start_location_name')->nullable();
            $table->string('start_location_latitude');
            $table->string('start_location_longitude');
            $table->string('final_location_name')->nullable();
            $table->string('final_location_latitude');
            $table->string('final_location_longitude');
            $table->dateTime('departure_date');
            $table->integer('age');
            $table->integer('total_passenger');
            $table->integer('vehicle_class_id')->unsigned()->nullable();
            $table->string('number_plate')->nullable();
            $table->string('passenger_type')->nullable();
            $table->timestamps();
        });

        // Schema::table('trip_plans', function(Blueprint $table) {
        //     $table->foreign('vehicle_class_id')->references('id')->on('vehicle_classes');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_plans');
    }
}
