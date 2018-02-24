<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker = Faker\Factory::create();
		for ($i = 0; $i <= 30; $i++) {
            if ($i < 10 ){
                $for_locum = 0;
                $for_practice = 1;
            }elseif ($i < 20){
                $for_locum = 1;
                $for_practice = 0;
            }else{
                $for_locum = 1;
                $for_practice = 1;
            }
			DB::table('news')->insert([
				'title'     => $faker->unique()->text($maxNbChars = 30),
				'content'    => $faker->unique()->text($maxNbChars = 250),
				'created_at'  => Carbon::now()->subMinutes(rand(0, 60)),
                'for_locum' => $for_locum,
                'for_practice' =>  $for_practice
			]);
		}
    }
}
