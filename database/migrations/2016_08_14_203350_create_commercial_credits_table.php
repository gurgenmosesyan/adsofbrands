<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommercialCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_credits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commercial_id')->unsigned();
            $table->string('position');
            $table->integer('sort_order')->unsigned();
            $table->index('commercial_id', 'commercial_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('commercial_credits');
    }
}
