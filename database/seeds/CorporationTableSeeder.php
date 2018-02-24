<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
class CorporationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i = 1; $i <= 2; $i++) {
            $corporation = new \App\Corporation();
            $corporation->name = $faker->unique()->company();
            $corporation->email = $faker->unique()->email();
            $corporation->setPasswordAttribute('corporation');
            $corporation->save();
        }
    }
}
