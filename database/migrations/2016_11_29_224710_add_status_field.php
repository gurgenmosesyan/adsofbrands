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
            $table->string('show_token', 100)->after('show_status');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->enum('show_status', [Model::STATUS_ACTIVE, Model::STATUS_INACTIVE])->after('blocked');
            $table->string('show_token', 100)->after('show_status');
        });
        Schema::table('creatives', function (Blueprint $table) {
            $table->enum('show_status', [Model::STATUS_ACTIVE, Model::STATUS_INACTIVE])->after('blocked');
            $table->string('show_token', 100)->after('show_status');
        });
        Schema::table('commercials', function (Blueprint $table) {
            $table->enum('show_status', [Model::STATUS_ACTIVE, Model::STATUS_INACTIVE])->after('qt');
            $table->string('show_token', 100)->after('show_status');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->enum('show_status', [Model::STATUS_ACTIVE, Model::STATUS_INACTIVE])->after('date');
            $table->string('show_token', 100)->after('show_status');
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
            $table->dropColumn('show_token');
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('show_status');
            $table->dropColumn('show_token');
        });
        Schema::table('creatives', function (Blueprint $table) {
            $table->dropColumn('show_status');
            $table->dropColumn('show_token');
        });
        Schema::table('commercials', function (Blueprint $table) {
            $table->dropColumn('show_status');
            $table->dropColumn('show_token');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('show_status');
            $table->dropColumn('show_token');
        });
    }
}
