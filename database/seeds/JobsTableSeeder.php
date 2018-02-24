<?php
use App\Application;
use App\Job;
use App\Percentage;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobsTableSeeder extends Seeder {
	
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		
		$faker  = Faker\Factory::create();
		$job_id = collect( [] );
		$users  = collect( [] );
		
		
		for($i = 0; $i <= 1000; $i++) {
			$rand          = rand( 1, 0 );
			$user_id       = ($rand ? rand( 1, 5 ) : NULL);
			$start_day     = $faker->unique()->dateTime();
			$new_start_day = Carbon::createFromFormat( 'Y-m-d', $start_day->format( 'Y-m-d' ) )->addDays( rand( 10, 50 ) );
			$end_date      = Carbon::createFromFormat( 'Y-m-d', $new_start_day->format( 'Y-m-d' ) )->addDays( rand( 10, 50 ) );
			
			DB::table( 'jobs' )->insert( [
				'practice_id'       => rand( 3, 5 ),
				'user_id'           => $user_id,
				'title'             => $faker->unique()->text( $maxNbChars = 10 ),
				'desc'              => $faker->unique()->text( $maxNbChars = 50 ),
				'day_rate'          => rand( 10, 500 ),
				'application_start' => $start_day,
				'application_end'   => $new_start_day,
				'job_start'         => $new_start_day,
				'job_end'           => $end_date,
				'invoice_id'        => null,
				'completed'         => $rand ? (bool)rand( 0, 1 ) : FALSE,
				'created_at'        => Carbon::now()->subMinutes( rand( 0, 60 ) ),
			] );
			if($user_id != NULL) {
				$job_id->push( (integer)DB::getPdo()->lastInsertId() );
				$users->push( $user_id );
			}
			
		}
		
		foreach($users as $key => $value) {
			
			DB::table( 'applications' )->insert( [
				'user_id'    => $value,
				'job_id'     => $job_id->get( $key ),
				'desc'       => $faker->unique()->text( $maxNbChars = 50 ),
				'created_at' => Carbon::now()->subMinutes( rand( 0, 60 ) ),
			] );
			
		}
	}
}
