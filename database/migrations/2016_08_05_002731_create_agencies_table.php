<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alias');
            $table->string('image');
            $table->string('cover');
            $table->string('email');
            $table->string('phone');
            $table->string('link');
            $table->string('fb');
            $table->string('twitter');
            $table->string('google');
            $table->string('youtube');
            $table->string('linkedin');
            $table->string('vimeo');
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
        Schema::drop('agencies');
    }
}