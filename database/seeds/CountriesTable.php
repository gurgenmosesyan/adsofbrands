<?php

use Illuminate\Database\Seeder;

class CountriesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileData = File::get(database_path('resources/countries.json'));
        $fileData = json_decode($fileData);

        $data = [];
        $i = 0;
        foreach ($fileData as $country) {
            $data[$i]['name_hy'] = $country->name_hy;
            $data[$i]['name_en'] = $country->name_en;
            $data[$i]['name_ru'] = $country->name_ru;
            $i++;
        }


        DB::table('countries')->truncate();
        DB::table('countries')->insert($data);
    }
}
