<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Core\Language\Language;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 30);
            $table->string('name');
            $table->string('icon');
            $table->enum('default', [Language::NOT_DEFAULT_LNG, Language::DEFAULT_LNG]);
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
        Schema::drop('languages');
    }
}
