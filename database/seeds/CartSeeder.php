<?php

use App\Cart;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
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
            Cart::insert([
                "organizer_id" => $faker->numberBetween(1, 3),
                "product_id" => $faker->numberBetween(1, 20),
                "quantity" => $faker->numberBetween(1, 10)
            ]);
        }
    }
}
