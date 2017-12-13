<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotElectionPollingUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pivot_election_polling_units', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('election_id')->unsigned()->index();
            $table->integer('state_id')->unsigned()->index();
            $table->integer('constituency_id')->unsigned()->index()->nullable();
            $table->integer('ward_id')->unsigned()->index();
            $table->integer('lga_id')->unsigned()->index();
            $table->integer('polling_unit_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index()->nullable();
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
        Schema::dropIfExists('pivot_election_polling_units');
    }
}
