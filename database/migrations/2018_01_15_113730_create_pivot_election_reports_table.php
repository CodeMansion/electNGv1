<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotElectionReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('election_reports', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->integer('election_id')->unsigned()->index();
            $table->integer('state_id')->unsigned()->index();
            $table->integer('constituency_id')->unsigned()->index()->nullable();
            $table->integer('ward_id')->unsigned()->index();
            $table->integer('lga_id')->unsigned()->index();
            $table->integer('polling_station_id')->unsigned()->index();
            $table->integer('status')->default(1);
            $table->string('comment');
            $table->string('title');
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
        Schema::dropIfExists('pivot_election_reports');
    }
}
