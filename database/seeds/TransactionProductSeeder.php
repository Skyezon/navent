<?php

use App\Constants\TransactionStatus;
use App\TransactionProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $status = [
            TransactionStatus::ARRIVED,
            TransactionStatus::CLOSED,
            TransactionStatus::WAITING_CONFIRMATION
        ];
        for ($j = 0; $j < 10; $j++) {
            TransactionProduct::insert([
                "status" => $status[rand(0, count($status) - 1)],
                "organizer_id" => rand(1, 3),
            ]);
        }
        for ($j = 0; $j < 5; $j++) {
            DB::table("transaction_product_details")->insert([
                "transaction_id" => rand(1, 10),
                'product_name' => $faker->text,
                'quantity' => rand(1, 5),
                "product_price" => rand(1000, 300000)
            ]);
        }
    }
}
