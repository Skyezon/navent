<?php

use App\Constants\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $role = [
            Role::MEMBERS,
            Role::ORGANIZER,
            Role::VENDOR,
            Role::ADMIN
        ];
        for ($j = 0; $j < 9; $j++) {
            User::insert([
                'name' =>  $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('secret'),
                'role' => $role[$j % 3]
            ]);
        }
    }
}
