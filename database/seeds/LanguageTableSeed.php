<?php

use Illuminate\Database\Seeder;

class LanguageTableSeed extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$data = [
			[
				'name' => 'English',
				'code' => 'en'
			],
            [
                'name' => 'Armenian',
                'code' => 'hy'
            ],
            [
                'name' => 'Russian',
                'code' => 'ru'
            ]
		];

		DB::table('languages')->truncate();
		DB::table('languages')->insert($data);
	}
}
