<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommercialAdvertisingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_advertising', function (Blueprint $table) {
            $table->integer('commercial_id')->unsigned();
            $table->string('name');
            $table->string('link');
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
        Schema::drop('commercial_advertising');
    }
}
