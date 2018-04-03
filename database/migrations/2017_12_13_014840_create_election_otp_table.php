<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectionOtpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('election_passcodes', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->integer('election_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->integer('constituency_id')->unsigned()->nullable();
            $table->integer('lga_id')->unsigned();
            $table->integer('ward_id')->unsigned();
            $table->integer('polling_station_id')->unsigned();
            $table->string('api_token',60)->unique()->nullable();
            $table->string('otp',6);
            $table->integer('status')->default(1);
            $table->timestamps();

            $table->foreign('election_id')->references('id')->on('elections');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('constituency_id')->references('id')->on('constituencies');
            $table->foreign('lga_id')->references('id')->on('lgas');
            $table->foreign('ward_id')->references('id')->on('wards');
            $table->foreign('polling_station_id')->references('id')->on('polling_stations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('election_onetime_passwords');
    }
}
