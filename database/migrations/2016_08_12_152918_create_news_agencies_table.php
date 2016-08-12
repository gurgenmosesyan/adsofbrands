<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_agencies', function (Blueprint $table) {
            $table->integer('news_id')->unsigned();
            $table->integer('agency_id')->unsigned();
            $table->primary(['news_id', 'agency_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('news_agencies');
    }
}
