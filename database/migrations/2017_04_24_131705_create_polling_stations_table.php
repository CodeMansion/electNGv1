<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollingStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polling_stations', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->text('slug', 191);
            $table->integer('state_id')->unsigned()->index();
            $table->integer('constituency_id')->unsigned()->index()->nullable();
            $table->integer('lga_id')->unsigned()->index();
            $table->integer('ward_id')->unsigned()->index();
            $table->string('name');
            $table->string('code')->nullable();
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('constituency_id')->references('id')->on('constituencies');
            $table->foreign('lga_id')->references('id')->on('lgas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polling_stations');
    }
}
