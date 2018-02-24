<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedbackTableSeeder extends Seeder {
	
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		
		$faker = Faker\Factory::create();
		
		for($i = 0; $i <= 20; $i++) {
			DB::table( 'feedback' )->insert( [
				'content'       => $faker->text( $maxNbChars = 80 ),
				'rating'     => rand( 0, 5 ),
				'user_id'    => rand( 1, 10 ),
				'job_id'    => rand( 1,  5),
				'created_at' => Carbon::now()->subMinutes( rand( 0, 60 ) ),
			] );
		}
	}
}
