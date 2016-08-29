<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsMlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_ml', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->tinyInteger('lng_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->text('text');
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
        Schema::drop('news_ml');
    }
}
