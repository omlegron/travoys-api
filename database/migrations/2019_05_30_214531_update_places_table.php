<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePlacesTable extends Migration
{
    public function __construct()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('photo_url')->nullable()->change();
            $table->unsignedBigInteger('category_id')->after('photo_url');
            $table->string('longitude')->nullable()->after('category_id');
            $table->string('latitude')->nullable()->after('longitude');
        });

        DB::table('places')
            ->where('type', 'restaurant')
            ->update([
                'category_id' => '1',
            ]);

        DB::table('places')
            ->where('type', 'attraction')
            ->update([
                'category_id' => '2',
            ]);

        Schema::table('places', function (Blueprint $table) {
            if (Schema::hasColumn('places', 'type'));
            {
                $table->dropColumn('type');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id')->change();
            $table->string('address')->change();
            $table->string('photo_url')->change();
            $table->enum('type', ['restaurant', 'attraction'])->after('photo_url');
            if (Schema::hasColumn('places', 'longitude'));
            {
                $table->dropColumn('longitude');
            }
            if (Schema::hasColumn('places', 'latitude'));
            {
                $table->dropColumn('latitude');
            }
        });

        DB::table('places')
            ->where('category_id', '1')
            ->update([
                'type' => 'restaurant',
            ]);

        DB::table('places')
            ->where('category_id', '2')
            ->update([
                'type' => 'attraction',
            ]);

        Schema::table('places', function (Blueprint $table) {
            if (Schema::hasColumn('places', 'category_id'));
            {
                $table->dropColumn('category_id');
            }
        });
    }
}
