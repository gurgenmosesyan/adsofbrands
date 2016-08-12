<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Commercial\Commercial;

class CreateCommercialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('media_type_id')->unsigned();
            $table->integer('industry_type_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->enum('featured', [Commercial::NOT_FEATURED, Commercial::FEATURED]);
            $table->enum('top', [Commercial::NOT_TOP, Commercial::TOP]);
            $table->date('published_date');
            $table->string('image');
            $table->string('image_big');
            $table->integer('views_count')->unsigned();
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
        Schema::drop('commercials');
    }
}
