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
        $dataMl = [];
        $i = 1;
        foreach ($fileData as $country) {
            $data[] = [
                'id' => $i,
                'icon' => $country->img,
                'created_at' => 'NULL',
                'updated_at' => 'NULL'
            ];
            $dataMl[] = [
                'id' => $i,
                'lng_id' => 1,
                'name' => $country->name_en
            ];
            $i++;
        }

        DB::table('countries')->truncate();
        DB::table('countries')->insert($data);

        DB::table('countries_ml')->truncate();
        DB::table('countries_ml')->insert($dataMl);
    }
}
