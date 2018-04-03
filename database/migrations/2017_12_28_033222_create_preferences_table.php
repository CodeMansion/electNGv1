<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('host');
            $table->string('username');
            $table->string('password');
            $table->string('encryption');
            $table->integer('port');
            $table->boolean('enable_page_refresh')->default(true);
            $table->boolean('enable_report_image')->default(false);
            $table->boolean('enable_integrity_check')->default(true);
            $table->boolean('enable_ward_result')->default(false);
            $table->boolean('enable_result_override')->default(false);
            $table->boolean('enable_sound_notification')->default(true);
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
        Schema::dropIfExists('preferences');
    }
}
