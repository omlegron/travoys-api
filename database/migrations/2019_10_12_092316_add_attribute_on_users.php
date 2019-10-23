<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttributeOnUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('saldo')->nullable();
            $table->string('golongan')->nullable();
            $table->string('rf_idkey')->nullable();
            $table->string('golongan_kendaraan')->nullable();
            $table->string('plat_no_kendaraan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['saldo']);
            $table->dropColumn(['golongan']);
            $table->dropColumn(['rf_idkey']);
            $table->dropColumn(['golongan_kendaraan']);
            $table->dropColumn(['plat_no_kendaraan']);
            // $table->string('jenis_kelamin')->nullable();
        });
    }
}
