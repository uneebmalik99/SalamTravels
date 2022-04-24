<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('transaction');
            $table->string('agency_name');
            $table->integer('booking_id')->unsigned();
            $table->integer('airline_id')->unsigned();
            $table->string('pnr');
            $table->string('to');
            $table->string('from');
            $table->date('dep_date');
            $table->date('arr_date');
            $table->integer('processed_by')->unsigned();
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
        Schema::dropIfExists('ledgers');
    }
}
