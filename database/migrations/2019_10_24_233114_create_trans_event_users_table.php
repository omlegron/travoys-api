<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransEventUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_event_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps('time');
            $table->unsignedInteger('created_by');
            $table->timestamps('created_at');
            $table->unsignedInteger('updated_by');
            $table->timestamps('updated_at');
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
        Schema::dropIfExists('trans_event_users');
    }
}
