<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($j = 0; $j < 20; $j++) {
            Product::insert([
                "name" => $faker->word,
                "price" => $faker->numberBetween(1000, 300000),
                "rating" => $faker->randomFloat(1, 1.0, 5.0),
                "stock" => $faker->numberBetween(0, 100),
                "description" => $faker->paragraph,
                "image" => $faker->imageUrl(),
                "type_id" => $faker->numberBetween(1, 10),
                "vendor_id" => $faker->numberBetween(1, 3)
            ]);
        }
    }
}
