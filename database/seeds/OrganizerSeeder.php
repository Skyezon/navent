<?php

use App\Constants\Location;
use App\Organizer;
use Illuminate\Database\Seeder;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($j = 2; $j < 9; $j += 3) {
            $province = array_keys(
                Location::LOCATION
            )[rand(0, count(Location::LOCATION) - 1)];
            $city = Location::LOCATION[$province][rand(0, count(Location::LOCATION[$province]) - 1)];
            Organizer::insert([
                'user_id' =>  $j,
                'name' => $faker->company,
                'phone_number' => $faker->phoneNumber,
                'image' => $faker->imageUrl(),
                'province' => $province,
                'city' => $city,
            ]);
        }
    }
}
