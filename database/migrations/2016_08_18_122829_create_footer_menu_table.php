<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\FooterMenu\FooterMenu;

class CreateFooterMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footer_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alias');
            $table->enum('static', FooterMenu::IS_NOT_STATIC, FooterMenu::IS_STATIC);
            $table->enum('hidden', FooterMenu::NOT_HIDDEN, FooterMenu::HIDDEN);
            $table->integer('sort_order')->unsigned();
            $table->timestamps();
            $table->index('alias', 'alias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('footer_menu');
    }
}
