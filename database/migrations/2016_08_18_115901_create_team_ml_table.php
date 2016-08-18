<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamMlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_ml', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->tinyInteger('lng_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('position');
            $table->primary(['id', 'lng_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('team_ml');
    }
}
