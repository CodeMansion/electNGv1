<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectionPartyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('election_parties', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->integer('election_id')->unsigned()->index();
            $table->integer('political_party_id')->unsigned()->index();
            $table->boolean('is_star_party')->default(false);
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->foreign('election_id')->references('id')->on('elections');
            $table->foreign('political_party_id')->references('id')->on('political_parties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pivot_election_party');
    }
}
