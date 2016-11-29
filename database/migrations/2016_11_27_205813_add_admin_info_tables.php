<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminInfoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->integer('add_admin_id')->unsigned()->default(0)->after('updated_at');
            $table->integer('update_admin_id')->unsigned()->default(0)->after('add_admin_id');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->integer('add_admin_id')->unsigned()->default(0)->after('updated_at');
            $table->integer('update_admin_id')->unsigned()->default(0)->after('add_admin_id');
        });
        Schema::table('creatives', function (Blueprint $table) {
            $table->integer('add_admin_id')->unsigned()->default(0)->after('updated_at');
            $table->integer('update_admin_id')->unsigned()->default(0)->after('add_admin_id');
        });
        Schema::table('commercials', function (Blueprint $table) {
            $table->integer('add_admin_id')->unsigned()->default(0)->after('updated_at');
            $table->integer('update_admin_id')->unsigned()->default(0)->after('add_admin_id');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->integer('add_admin_id')->unsigned()->default(0)->after('updated_at');
            $table->integer('update_admin_id')->unsigned()->default(0)->after('add_admin_id');
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
            $table->dropColumn('add_admin_id');
            $table->dropColumn('update_admin_id');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn('add_admin_id');
            $table->dropColumn('update_admin_id');
        });
        Schema::table('creatives', function (Blueprint $table) {
            $table->dropColumn('add_admin_id');
            $table->dropColumn('update_admin_id');
        });
        Schema::table('commercials', function (Blueprint $table) {
            $table->dropColumn('add_admin_id');
            $table->dropColumn('update_admin_id');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('add_admin_id');
            $table->dropColumn('update_admin_id');
        });
    }
}
