<?php

use App\TransactionEvent;
use Illuminate\Database\Seeder;

class TransactionEventSeeder extends Seeder
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
            TransactionEvent::insert([
                "member_id" => $faker->numberBetween(1, 3),
                "event_id" => $faker->numberBetween(1, 10),
                "quantity" => $faker->numberBetween(1, 5),
                "promo_id" => $faker->numberBetween(1, 4)
            ]);
        }
    }
}
