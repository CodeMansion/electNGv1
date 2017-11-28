<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectionPollResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('election_poll_results', function (Blueprint $table) {
            $table->increments('id');
            $table->text('slug', 191);
            $table->integer('election_id')->unsigned()->index();
            $table->integer('state_id')->unsigned()->index();
            $table->integer('lga_id')->unsigned()->index();
            $table->integer('ward_id')->unsigned()->index();
            $table->integer('political_party_id')->unsigned()->index();
            $table->integer('score');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('election_poll_results');
    }
}
