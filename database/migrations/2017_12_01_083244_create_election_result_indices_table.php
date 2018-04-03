<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectionResultIndicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('election_entries', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->integer('election_id')->unsigned()->index();
            $table->integer('political_party_id')->unsigned()->index()->nullable();
            $table->integer('state_id')->unsigned()->index();
            $table->integer('constituency_id')->unsigned()->index()->nullable();
            $table->integer('ward_id')->unsigned()->index();
            $table->integer('lga_id')->unsigned()->index();
            $table->integer('polling_station_id')->unsigned()->index();
            $table->integer('accr_voters');
            $table->integer('void_voters');
            $table->integer('confirmed_voters');
            $table->boolean('is_latest')->default(false);
            $table->boolean('is_submitted')->default(false);
            $table->string('party_code');
            $table->integer('votes');
            $table->timestamps();

            $table->foreign('election_id')->references('id')->on('elections');
            $table->foreign('political_party_id')->references('id')->on('political_parties');
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
        Schema::dropIfExists('election_result_indices');
    }
}
