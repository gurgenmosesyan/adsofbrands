<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Brand\Brand;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('alias');
            $table->string('image');
            $table->string('cover');
            $table->string('email');
            $table->string('password')->nullable();
            $table->string('phone');
            $table->string('link');
            $table->enum('top', [Brand::NOT_TOP, Brand::TOP]);
            $table->string('fb');
            $table->string('twitter');
            $table->string('google');
            $table->string('youtube');
            $table->string('linkedin');
            $table->string('vimeo');
            $table->string('hash');
            $table->rememberToken();
            $table->enum('status', ['', Brand::STATUS_PENDING, Brand::STATUS_CONFIRMED]);
            $table->enum('active', [Brand::ACTIVE, Brand::NOT_ACTIVE]);
            $table->enum('blocked', [Brand::NOT_BLOCKED, Brand::BLOCKED]);
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
        Schema::drop('brands');
    }
}
