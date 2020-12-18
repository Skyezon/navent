<?php

use App\Constants\Location;
use App\Event;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
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
            $now = Carbon::now()->addDays(rand(-1, -30));
            $province = array_keys(
                Location::LOCATION
            )[rand(0, count(Location::LOCATION) - 1)];
            $city = Location::LOCATION[$province][rand(0, count(Location::LOCATION[$province]) - 1)];
            Event::insert([
                "organizer_id" => rand(1, 3),
                "type_id" => rand(1, 10),
                "name" => $faker->word,
                "date_start" => $now,
                "date_end" => $now->addDay(),
                'image' => $faker->imageUrl(),
                'address' => $faker->address,
                'province' => $province,
                'description' => $faker->paragraph,
                'city' => $city,
                'price' => $faker->numberBetween(0, 3000),
                'slot' => $faker->numberBetween(0, 300)
            ]);
        }
    }
}
