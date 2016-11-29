<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminInfoAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->integer('add_admin_id')->unsigned()->default(0)->after('updated_at');
            $table->integer('update_admin_id')->unsigned()->default(0)->after('add_admin_id');
        });
        Schema::table('media_types', function (Blueprint $table) {
            $table->integer('add_admin_id')->unsigned()->default(0)->after('updated_at');
            $table->integer('update_admin_id')->unsigned()->default(0)->after('add_admin_id');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('add_admin_id')->unsigned()->default(0)->after('updated_at');
            $table->integer('update_admin_id')->unsigned()->default(0)->after('add_admin_id');
        });
        Schema::table('agency_categories', function (Blueprint $table) {
            $table->integer('add_admin_id')->unsigned()->default(0)->after('updated_at');
            $table->integer('update_admin_id')->unsigned()->default(0)->after('add_admin_id');
        });
        Schema::table('awards', function (Blueprint $table) {
            $table->integer('add_admin_id')->unsigned()->default(0)->after('updated_at');
            $table->integer('update_admin_id')->unsigned()->default(0)->after('add_admin_id');
        });
        Schema::table('vacancies', function (Blueprint $table) {
            $table->integer('add_admin_id')->unsigned()->default(0)->after('updated_at');
            $table->integer('update_admin_id')->unsigned()->default(0)->after('add_admin_id');
        });
        Schema::table('branches', function (Blueprint $table) {
            $table->integer('add_admin_id')->unsigned()->default(0)->after('updated_at');
            $table->integer('update_admin_id')->unsigned()->default(0)->after('add_admin_id');
        });
        Schema::table('team', function (Blueprint $table) {
            $table->integer('add_admin_id')->unsigned()->default(0)->after('updated_at');
            $table->integer('update_admin_id')->unsigned()->default(0)->after('add_admin_id');
        });
        Schema::table('banners', function (Blueprint $table) {
            $table->integer('add_admin_id')->unsigned()->default(0)->after('updated_at');
            $table->integer('update_admin_id')->unsigned()->default(0)->after('add_admin_id');
        });
        Schema::table('footer_menu', function (Blueprint $table) {
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
        Schema::table('languages', function (Blueprint $table) {
            $table->dropColumn('add_admin_id');
            $table->dropColumn('update_admin_id');
        });
        Schema::table('media_types', function (Blueprint $table) {
            $table->dropColumn('add_admin_id');
            $table->dropColumn('update_admin_id');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('add_admin_id');
            $table->dropColumn('update_admin_id');
        });
        Schema::table('agency_categories', function (Blueprint $table) {
            $table->dropColumn('add_admin_id');
            $table->dropColumn('update_admin_id');
        });
        Schema::table('awards', function (Blueprint $table) {
            $table->dropColumn('add_admin_id');
            $table->dropColumn('update_admin_id');
        });
        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropColumn('add_admin_id');
            $table->dropColumn('update_admin_id');
        });
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn('add_admin_id');
            $table->dropColumn('update_admin_id');
        });
        Schema::table('team', function (Blueprint $table) {
            $table->dropColumn('add_admin_id');
            $table->dropColumn('update_admin_id');
        });
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('add_admin_id');
            $table->dropColumn('update_admin_id');
        });
        Schema::table('footer_menu', function (Blueprint $table) {
            $table->dropColumn('add_admin_id');
            $table->dropColumn('update_admin_id');
        });
    }
}
