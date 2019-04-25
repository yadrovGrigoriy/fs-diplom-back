<?php

use Illuminate\Database\Seeder;

class FilmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
 
        for ($i = 0; $i < 10; $i++) {
            Film::create([
                'title' => $faker->title,
                'duration' => $faker-> randomNumber($nbDigits = NULL, $strict = false),
                'poster' => $faker->word, 
                'description' => $faker->paragraph,
                'country' => $faker->country
            ]);
        }
    }
}
