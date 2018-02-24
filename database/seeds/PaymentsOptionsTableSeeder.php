<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i <= 20; $i++) {
            DB::table('payments_options')->insert([
                'user_id'    => rand(1, 10),
                'card_number' => $faker->creditCardNumber(),
                'card_expiry_month'   => rand(1,12),
                'card_expiry_year'   => $faker->year(),
                'card_type'   => $faker->creditCardType(),
                'cardholder_first_name'   => $faker->firstName(),
                'cardholder_last_name'   => $faker->lastName(),
                'created_at' => Carbon::now()->subMinutes(rand(0, 60)),
            ]);
        }
    }
}
