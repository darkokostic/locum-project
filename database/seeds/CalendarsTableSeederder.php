<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalendarsTableSeederder extends Seeder {
	
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		
		for($i = 1; $i < 10; $i++) {
			$month = rand( 1, 8 );
			$day   = rand( 1, 28 );
			$start = Carbon::createFromDate( 2017, $month, $day );
			
			$end = Carbon::createFromDate( 2017, $month, $month + $day );;
			DB::table( 'calendars' )->insert( [
				'user_id'    => 1,
				'start_date' => $start,
				'end_date'   => $end,
				'desc'       => 'Available for hire',
				'created_at' => Carbon::now()->subMinutes( rand( 0, 60 ) ),
			] );
		}
		
		
	}
}
