<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommercialAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_agencies', function (Blueprint $table) {
            $table->integer('commercial_id')->unsigned();
            $table->integer('agency_id')->unsigned();
            $table->primary(['commercial_id', 'agency_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('commercial_agencies');
    }
}
