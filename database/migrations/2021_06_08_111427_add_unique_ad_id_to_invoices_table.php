<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddUniqueAdIdToInvoicesTable
 */
class AddUniqueAdIdToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->unique(['ad_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['ad_id']);

            $table->dropUnique(['ad_id']);

            $table->foreign('ad_id')->references('id')->on('ads')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }
}
