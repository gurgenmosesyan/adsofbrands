<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsCreativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_creatives', function (Blueprint $table) {
            $table->integer('news_id')->unsigned();
            $table->integer('creative_id')->unsigned();
            $table->primary(['news_id', 'creative_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('news_creatives');
    }
}
