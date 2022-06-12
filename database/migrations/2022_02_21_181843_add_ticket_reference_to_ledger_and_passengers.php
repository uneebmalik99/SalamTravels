<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketReferenceToLedgerAndPassengers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passengers', function (Blueprint $table) {
            $table->integer('tabtype_id')->unsigned()->nullable()->after('processed_by');
        });
        Schema::table('ledgers', function (Blueprint $table) {
            $table->integer('tabtype_id')->unsigned()->nullable()->after('processed_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ledger_and_passengers', function (Blueprint $table) {
            //
        });
    }
}
