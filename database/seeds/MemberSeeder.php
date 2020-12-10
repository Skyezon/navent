<?php

use App\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($j = 1; $j < 9; $j += 3) {
            Member::insert([
                'user_id' =>  $j,
                'name' => $faker->company,
                'phone_number' => $faker->phoneNumber
            ]);
        }
    }
}
