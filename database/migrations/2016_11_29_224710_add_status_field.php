<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Core\Model;

class AddStatusField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->enum('show_status', [Model::STATUS_ACTIVE, Model::STATUS_INACTIVE])->after('blocked');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->enum('show_status', [Model::STATUS_ACTIVE, Model::STATUS_INACTIVE])->after('blocked');
        });
        Schema::table('creatives', function (Blueprint $table) {
            $table->enum('show_status', [Model::STATUS_ACTIVE, Model::STATUS_INACTIVE])->after('blocked');
        });
        Schema::table('commercials', function (Blueprint $table) {
            $table->enum('show_status', [Model::STATUS_ACTIVE, Model::STATUS_INACTIVE])->after('qt');
            $table->string('hash', 100)->after('show_status');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->enum('show_status', [Model::STATUS_ACTIVE, Model::STATUS_INACTIVE])->after('date');
            $table->string('hash', 100)->after('show_status');
        });
        Schema::table('footer_menu', function (Blueprint $table) {
            $table->enum('show_status', [Model::STATUS_ACTIVE, Model::STATUS_INACTIVE])->after('sort_order');
            $table->string('hash', 100)->after('show_status');
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
            $table->dropColumn('show_status');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn('show_status');
        });
        Schema::table('creatives', function (Blueprint $table) {
            $table->dropColumn('show_status');
        });
        Schema::table('commercials', function (Blueprint $table) {
            $table->dropColumn('show_status');
            $table->dropColumn('hash');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('show_status');
            $table->dropColumn('hash');
        });
        Schema::table('footer_menu', function (Blueprint $table) {
            $table->dropColumn('show_status');
            $table->dropColumn('hash');
        });
    }
}
