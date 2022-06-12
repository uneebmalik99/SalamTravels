<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabInfo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('airline_name');
            $table->string('pnr');
            $table->unsignedBigInteger('booking_source');
            $table->string('sector');
            $table->string('date');
            $table->string('passenger_name');
            $table->string('remarks')->nullable();
            $table->string('admin_remarks')->nullable();
            $table->unsignedBigInteger('status')->default(5);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tab_type');
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
        Schema::dropIfExists('tab_info');
    }
}
