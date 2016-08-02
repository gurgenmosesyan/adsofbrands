<?php

use Illuminate\Database\Seeder;

class AdminTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
	        'email' => 'admin@admin.com',
	        'password' => bcrypt('asdasd1'),
            'lng_id' => 1
        ];

		DB::table('adm_users')->truncate();
	    DB::table('adm_users')->insert($data);
    }
}
