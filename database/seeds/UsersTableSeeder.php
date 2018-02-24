d<?php
use App\Helpers\Constant;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder {
	
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		
		$faker = Faker\Factory::create();
		
		for($i = 0; $i <= 6; $i++) {
			DB::table( 'users' )->insert( [
				'name'             => $faker->unique()->name(),
				'email'            => $faker->unique()->email(),
				'password'         => bcrypt( 123 ),
				'address1'         => $faker->unique()->address(),
				'address2'         => $faker->unique()->address(),
				'city'             => $faker->unique()->city(),
				'province'         => $faker->unique()->country(),
				'postal_code'      => rand(123456 , 654321),
				'lat'              => $faker->unique()->latitude(),
				'lng'              => $faker->unique()->longitude(),
				'phone'            => rand(1234567890 , 1987654321),
				'website'          => $faker->unique()->domainName(),
				'linkedin'         => 'https://www.linkedin.com/' . $faker->unique()->userName(),
				'graduated_year'   => $faker->unique()->year(),
				'day_rate'         => rand( 10, 500 ),
				'handover_between' => (bool)rand( 0, 1 ),
				'radius'           => rand( 0, 100 ),
				'visible'          => (bool)rand( 0, 1 ),
				#'role'             => (rand( 0, 1 )) ? Constant::ROLE_OWNER : Constant::ROLE_USER,
				'role'             => Constant::ROLE_USER,
				#'avatar'           => (rand( 0, 1 )) ? Constant::PRACTICE_DEFAULT_AVATAR_PATH : Constant::LOCUM_DEFAULT_AVATAR_PATH,
				'avatar'           => Constant::LOCUM_DEFAULT_AVATAR_PATH,
				'created_at'       => Carbon::now()->subMinutes( rand( 0, 60 ) ),
			
			] );
		}for($i = 1; $i <= 5; $i++) {
			DB::table( 'users' )->insert( [
				'name'             => $faker->unique()->name(),
				'email'            => $faker->unique()->email(),
				'password'         => bcrypt( 123 ),
				'address1'         => $faker->unique()->address(),
				'address2'         => $faker->unique()->address(),
				'city'             => $faker->unique()->city(),
				'province'         => $faker->unique()->country(),
				'postal_code'      => rand(123456 , 654321),
				'lat'              => $faker->unique()->latitude(),
				'lng'              => $faker->unique()->longitude(),
				'phone'            => rand(1234567890 , 1987654321),
				'website'          => $faker->unique()->domainName(),
				'linkedin'         => 'https://www.linkedin.com/' . $faker->unique()->userName(),
				'graduated_year'   => $faker->unique()->year(),
				'day_rate'         => rand( 10, 500 ),
				'handover_between' => (bool)rand( 0, 1 ),
				'radius'           => rand( 0, 100 ),
				'visible'          => (bool)rand( 0, 1 ),
				#'role'             => (rand( 0, 1 )) ? Constant::ROLE_OWNER : Constant::ROLE_USER,
				'role'             => Constant::ROLE_OWNER,
				#'avatar'           => (rand( 0, 1 )) ? Constant::PRACTICE_DEFAULT_AVATAR_PATH : Constant::LOCUM_DEFAULT_AVATAR_PATH,
				'avatar'           => Constant::PRACTICE_DEFAULT_AVATAR_PATH,
				'created_at'       => Carbon::now()->subMinutes( rand( 0, 60 ) ),
			
			] );
		}
	}
}
