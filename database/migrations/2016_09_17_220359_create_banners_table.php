<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Banner\Banner;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('key', [
                Banner::KEY_HOMEPAGE_1,
                Banner::KEY_HOMEPAGE_2,
                Banner::KEY_HOMEPAGE_RIGHT,
                Banner::KEY_RIGHT_BLOCK,
            ]);
            $table->enum('type', [Banner::TYPE_IMAGE, Banner::TYPE_EMBED]);
            $table->string('image');
            $table->text('embed');
            $table->string('link');
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
        Schema::drop('banners');
    }
}
