<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Core\Admin\Admin;

class ChangeAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adm_users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->enum('super_admin', [Admin::NOT_SUPER_ADMIN, Admin::SUPER_ADMIN])->after('password');
            $table->text('permissions')->after('super_admin');
            $table->string('homepage')->after('permissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adm_users', function (Blueprint $table) {
            $table->dropColumn('super_admin');
            $table->enum('role', ['admin', 'manager'])->after('password');
            $table->dropColumn('text');
            $table->dropColumn('homepage');
        });
    }
}
