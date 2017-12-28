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
        Schema::create('election_onetime_passwords', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('election_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->integer('constituency_id')->unsigned()->nullable();
            $table->integer('lga_id')->unsigned();
            $table->integer('ward_id')->unsigned();
            $table->integer('polling_unit_id')->unsigned();
            $table->string('api_token',60)->unique()->nullable();
            $table->string('otp',6);
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
        Schema::dropIfExists('election_onetime_passwords');
    }
}
