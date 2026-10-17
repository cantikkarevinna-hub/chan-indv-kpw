<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Film;
use Faker\Factory as Faker;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $csvFile = fopen(base_path("database/data/movies.csv"), "r");
        $faker = Faker::create('id_ID');

        $firstline = true;
        while (($data = fgetcsv($csvFile, 200, ";")) !== FALSE) {
            if (!$firstline) {
                Film::create([
                    "poster"    => str_replace("storage/images/", "template/images/", $data['0']),
                    "title"     => $data['1'],
                    "year"      => $data['2'],
                    "genre_id"  => $data['3'],
                    "sinopsis"  => $faker->text($maxNbChars = 200),
                ]);    
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
