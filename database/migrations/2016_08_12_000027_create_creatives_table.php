<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Creative\Creative;

class CreateCreativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creatives', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', [Creative::TYPE_PERSONAL, Creative::TYPE_BRAND, Creative::TYPE_AGENCY]);
            $table->integer('type_id')->unsigned();
            $table->string('alias');
            $table->string('image');
            $table->string('cover');
            $table->string('email');
            $table->string('password')->nullable();
            $table->string('phone');
            $table->string('link');
            $table->string('fb');
            $table->string('twitter');
            $table->string('google');
            $table->string('youtube');
            $table->string('linkedin');
            $table->string('vimeo');
            $table->string('hash');
            $table->rememberToken();
            $table->enum('status', ['', Creative::STATUS_PENDING, Creative::STATUS_CONFIRMED]);
            $table->enum('active', [Creative::ACTIVE, Creative::NOT_ACTIVE]);
            $table->enum('blocked', [Creative::NOT_BLOCKED, Creative::BLOCKED]);
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
        Schema::drop('creatives');
    }
}
