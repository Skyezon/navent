<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(VendorSeeder::class);
        $this->call(OrganizerSeeder::class);
        $this->call(MemberSeeder::class);
        $this->call(ProductTypeSeeder::class);
        $this->call(EventTypeSeeder::class);
        $this->call(PromoSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CartSeeder::class);
        $this->call(TransactionProductSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(TransactionEventSeeder::class);
    }
}
