<?php

use App\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($j = 0; $j < 10; $j++) {
            ProductType::insert([
                "name" => $faker->name
            ]);
        }
    }
}
