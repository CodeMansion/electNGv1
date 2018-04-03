<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elections', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->text('slug', 191);
            $table->string('name');
            $table->string('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('election_status_id')->unsigned()->index();
            $table->integer('election_type_id')->unsigned()->index();
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->foreign('election_status_id')->references('id')->on('election_statuses');
            $table->foreign('election_type_id')->references('id')->on('election_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elections');
    }
}
