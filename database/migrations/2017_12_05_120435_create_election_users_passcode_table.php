<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectionUsersPasscodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pivot_election_users_passcode', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('election_id');
            $table->integer('state_id');
            $table->integer('lga_id');
            $table->integer('ward_id');
            $table->integer('polling_station_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->string('token')->nullable();
            $table->integer('status')->default(1);
            $table->text('passcode');
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
        Schema::dropIfExists('election_users_passcode');
    }
}
