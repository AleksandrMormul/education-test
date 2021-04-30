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
            $table->string('country', 2)->index()->after('description');
            $table->string('phone_number', 12)->index()->after('description');
            $table->decimal('latitude')->after('phone_number');
            $table->decimal('longitude')->after('latitude');
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
            $table->dropColumn('country');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }
}
