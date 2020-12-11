<?php

use App\EventType;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
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
            EventType::insert([
                "name" => $faker->name
            ]);
        }
    }
}
