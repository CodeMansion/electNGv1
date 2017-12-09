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
        Schema::create('election_result_indices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('state_id')->unsigned()->index();
            $table->integer('election_id')->unsigned()->index();
            $table->string('election_code');
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
        Schema::dropIfExists('election_result_indices');
    }
}
