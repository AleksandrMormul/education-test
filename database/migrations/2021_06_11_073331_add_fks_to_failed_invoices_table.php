<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddFksToFailedInvoicesTable
 */
class AddFksToFailedInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('failed_invoices', function (Blueprint $table) {
            $table->foreign('ad_id')->references('id')->on('ads')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('invoice_id')->references('id')->on('invoices')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('failed_invoices', function (Blueprint $table) {
            $table->dropForeign(['ad_id']);
            $table->dropIndex('failed_invoices_ad_id_foreign');
            $table->dropForeign(['invoice_id']);
            $table->dropIndex('failed_invoices_invoice_id_foreign');
        });
    }
}
