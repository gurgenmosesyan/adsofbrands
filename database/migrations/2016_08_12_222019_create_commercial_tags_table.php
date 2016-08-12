<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommercialTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_tags', function (Blueprint $table) {
            $table->integer('commercial_id')->unsigned();
            $table->string('tag');
            $table->primary(['commercial_id', 'tag']);
            $table->index('commercial_id', 'commercial_id');
            $table->index('tag', 'tag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('commercial_tags');
    }
}
