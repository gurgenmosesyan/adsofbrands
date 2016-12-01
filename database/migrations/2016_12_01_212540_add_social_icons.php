<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialIcons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('instagram')->after('vimeo');
            $table->string('pinterest')->after('instagram');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->string('instagram')->after('vimeo');
            $table->string('pinterest')->after('instagram');
        });
        Schema::table('creatives', function (Blueprint $table) {
            $table->string('instagram')->after('vimeo');
            $table->string('pinterest')->after('instagram');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('instagram');
            $table->dropColumn('pinterest');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn('instagram');
            $table->dropColumn('pinterest');
        });
        Schema::table('creatives', function (Blueprint $table) {
            $table->dropColumn('instagram');
            $table->dropColumn('pinterest');
        });
    }
}
