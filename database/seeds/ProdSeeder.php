<?php
use App\Application;
use App\Feedback;
use App\Helpers\Constant;
use App\Invoice;
use App\Job;
use App\Percentage;
use App\Practice;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$faker = Faker\Factory::create();
		/**
		 * Corporation
		 */
		DB::table( 'corporations' )->insert( [
			'name'       => 'Corporation ' . $faker->unique()->name(),
			'email'      => 'corporation@dev.com',
			'created_at' => Carbon::now(),
			'password'   => bcrypt( 'corporation' ),
		] );
		/**
		 * Admin
		 */
		DB::table( 'users' )->insert( [
			'name'           => $faker->unique()->name(),
			'email'          => 'admin@dev.com',
			'password'       => bcrypt( 'admin' ),
			'address1'       => $faker->unique()->address(),
			'address2'       => $faker->unique()->address(),
			'city'           => $faker->unique()->city(),
			'province'       => $faker->unique()->country(),
			'postal_code'    => rand(123456 , 654321),
			'lat'            => $faker->unique()->latitude(),
			'lng'            => $faker->unique()->longitude(),
			'phone'          => rand(1234567890 , 1987654321),
			'website'        => $faker->unique()->domainName(),
			'linkedin'       => 'https://www.linkedin.com/' . $faker->unique()->userName(),
			'graduated_year' => $faker->unique()->year(),
			'day_rate'       => rand( 10, 500 ),
			'radius'         => rand( 0, 100 ),
			'visible'        => (bool)rand( 0, 1 ),
			'created_at'     => Carbon::now()->subMinutes( rand( 0, 60 ) ),
			'role'           => Constant::ROLE_ADMIN,
		] );
	}
}