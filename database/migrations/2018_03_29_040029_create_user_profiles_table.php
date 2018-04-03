<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->text('slug', 191);
            $table->integer('user_id')->unsigned()->index();
            $table->string('last_name');
            $table->string('other_names');
            $table->integer('gender_id')->unsigned()->index();
            $table->integer('state_id')->unsigned()->index();
            $table->string('email', 180)->unique();
            $table->string('telephone', 11)->unique();
            $table->string('address');
            $table->integer('status')->default(0);
            $table->string('photo_file_name')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('gender_id')->references('id')->on('genders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
