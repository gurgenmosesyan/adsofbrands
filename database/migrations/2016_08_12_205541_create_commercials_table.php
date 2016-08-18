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
            $table->integer('category_id')->unsigned();
            $table->string('alias');
            $table->enum('type', [Commercial::TYPE_VIDEO, Commercial::TYPE_PRINT]);
            $table->enum('video_type', ['', Commercial::VIDEO_TYPE_YOUTUBE, Commercial::VIDEO_TYPE_VIMEO, Commercial::VIDEO_TYPE_FB, Commercial::VIDEO_TYPE_EMBED]);
            $table->text('video_data');
            $table->string('image_print');
            $table->enum('featured', [Commercial::NOT_FEATURED, Commercial::FEATURED]);
            $table->enum('top', [Commercial::NOT_TOP, Commercial::TOP]);
            $table->date('published_date');
            $table->string('image');
            $table->string('advertising');
            $table->integer('views_count')->unsigned();
            $table->float('rating')->unsigned();
            $table->integer('qt')->unsigned();
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
