<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Agency\Agency;

class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('alias');
            $table->string('image');
            $table->string('cover');
            $table->string('email');
            $table->string('password')->nullable();
            $table->string('phone');
            $table->string('link');
            $table->enum('top', [Agency::NOT_TOP, Agency::TOP]);
            $table->string('fb');
            $table->string('twitter');
            $table->string('google');
            $table->string('youtube');
            $table->string('linkedin');
            $table->string('vimeo');
            $table->string('hash');
            $table->rememberToken();
            $table->enum('status', ['', Agency::STATUS_PENDING, Agency::STATUS_CONFIRMED]);
            $table->enum('active', [Agency::ACTIVE, Agency::NOT_ACTIVE]);
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
        Schema::drop('agencies');
    }
}
