<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddNewColumnsToAdsTable
 */
class AddNewColumnsToAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->string('country_code', 2)->index()->after('description');
            $table->string('phone_number', 12)->index()->after('description');
            $table->decimal('latitude', 10, 8)->nullable()->after('phone_number');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn('country_code');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('phone_number');
        });
    }
}
