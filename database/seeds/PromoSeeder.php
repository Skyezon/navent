<?php

use App\Promo;
use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($j = 0; $j < 4; $j++) {
            Promo::insert([
                "code" => $faker->regexify('([A-Z]{3}[0-9]{2})'),
                "discount" => $faker->numberBetween(10000, 100000)
            ]);
        }
    }
}
