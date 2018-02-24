<?php
use App\Helpers\Constant;
use App\Practice;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class PracticesTableSeeder
 */
class PracticesTableSeeder extends Seeder {
	
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		
		$faker = Faker\Factory::create();
		
		for($i = 1; $i <= 5; $i++) {
			$corporation_id = 1;
			if(($i % 2) == 0) {
				$corporation_id = NULL;
			}
			DB::table( 'practices' )->insert( [
				'practice_name'        => $faker->unique()->company(),
				'practice_email'       => $faker->unique()->email(),
				'practice_address1'    => $faker->unique()->address(),
				'practice_address2'    => $faker->unique()->address(),
				'practice_city'        => $faker->unique()->city(),
				'practice_province'    => $faker->unique()->country(),
				'practice_postal_code' => rand(123456 , 654321),
				'practice_phone'       => rand(1234567890 , 1987654321),
				'lat'                  => $faker->unique()->latitude(),
				'lng'                  => $faker->unique()->longitude(),
				'practice_website'     => $faker->unique()->domainName(),
				'practice_facebook'    => 'https://www.facebook.com/' . $faker->unique()->userName(),
				'no_of_exam_lanes'     => $faker->unique()->text( $maxNbChars = 10 ),
				'no_of_staff'          => $faker->unique()->text( $maxNbChars = 10 ),
				'sq_ft'                => $faker->unique()->text( $maxNbChars = 10 ),
				'day_rate'             => rand( 10, 500 ),
				'practice_visible'     => (bool)rand( 0, 1 ),
				'user_id'              => 10+$i,
				'corporation_id'       => $corporation_id,
				'created_at'           => Carbon::now()->subMinutes( rand( 0, 60 ) ),
			] );
		}
	}
}
