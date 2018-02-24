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

class RealDataSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$faker = Faker\Factory::create();
		
		$locum_graduated_year = Carbon::create( rand( 1990, 2017 ), 1, 1, 0, 0, 0 )->format( 'Y' );
		DB::table( 'users' )->insert( [
			'name'           => 'Locum ' . $faker->unique()->name(),
			'email'          => 'locum@dev.com',
			'password'       => bcrypt( 'locum' ),
			'role'           => Constant::ROLE_USER,
			'address1'       => $faker->unique()->address(),
			'address2'       => $faker->unique()->address(),
			'city'           => $faker->unique()->city(),
			'province'       => $faker->unique()->country(),
			'lat'            => $faker->unique()->latitude(),
			'lng'            => $faker->unique()->longitude(),
			'postal_code'    => rand(123456 , 654321),
			'phone'          => rand(1234567890 , 1987654321),
			'website'        => $faker->unique()->domainName(),
			'linkedin'       => 'https://www.linkedin.com/' . $faker->unique()->userName(),
			'graduated_year' => $locum_graduated_year,
			'day_rate'       => rand( 10, 500 ),
			'overview'       => $faker->text( 555 ),
			'radius'         => rand( 0, 100 ),
			'visible'        => TRUE,
			'created_at'     => Carbon::now()->subMinutes( rand( 0, 60 ) ),
		] );
		
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
		
		$practice_graduated_year = Carbon::create( rand( 1945, 2017 ), 1, 1, 0, 0, 0 )->format( 'Y' );
		DB::table( 'users' )->insert( [
			'name'           => 'Practice ' . $faker->unique()->name(),
			'email'          => 'practice@dev.com',
			'password'       => bcrypt( 'practice' ),
			'role'           => Constant::ROLE_OWNER,
			'avatar'         => Constant::PRACTICE_DEFAULT_AVATAR_PATH,
			'address1'       => $faker->unique()->address(),
			'address2'       => $faker->unique()->address(),
			'city'           => $faker->unique()->city(),
			'province'       => $faker->unique()->country(),
			'lat'            => $faker->unique()->latitude(),
			'lng'            => $faker->unique()->longitude(),
			'postal_code'    => rand(123456 , 654321),
			'phone'          => rand(1234567890 , 1987654321),
			'website'        => $faker->unique()->domainName(),
			'linkedin'       => 'https://www.linkedin.com/' . $faker->unique()->userName(),
			'graduated_year' => $practice_graduated_year,
			'day_rate'       => rand( 10, 500 ),
			'overview'       => $faker->text( 555 ),
			'radius'         => rand( 0, 100 ),
			'visible'        => TRUE,
			'created_at'     => Carbon::now()->subMinutes( rand( 0, 60 ) ),
		] );
		
		DB::table( 'practices' )->insert( [
			'practice_name'        => 'Practice ' . $faker->unique()->company(),
			'practice_email'       => $faker->unique()->email(),
			'practice_address1'    => $faker->unique()->address(),
			'practice_address2'    => $faker->unique()->address(),
			'practice_city'        => $faker->unique()->city(),
			'practice_province'    => $faker->unique()->country(),
			'practice_postal_code' => rand(123456 , 654321),
			'avatar'               => Constant::PRACTICE_DEFAULT_AVATAR_PATH,
			'lat'                  => $faker->unique()->latitude(),
			'lng'                  => $faker->unique()->longitude(),
			'practice_phone'       => rand(1234567890 , 1987654321),
			'practice_website'     => $faker->unique()->domainName(),
			'practice_facebook'    => 'https://www.facebook.com/' . $faker->unique()->userName(),
			'overview'             => $faker->text( $maxNbChars = 555 ),
			'no_of_exam_lanes'     => $faker->unique()->text( $maxNbChars = 10 ),
			'no_of_staff'          => $faker->unique()->text( $maxNbChars = 10 ),
			'sq_ft'                => $faker->unique()->text( $maxNbChars = 10 ),
			'day_rate'             => rand( 10, 500 ),
			'practice_visible'     => TRUE,
			'user_id'              => 2,
			'corporation_id'       => 2,
			'created_at'           => Carbon::now()->subMinutes( rand( 0, 60 ) ),
		] );
		
		/*Uncompleted jobs P2*/
		$job                    = new Job;
		$job->practice_id       = 1;
		$job->user_id           = NULL;
		$job->title             = $faker->unique()->text( $maxNbChars = 35 );
		$job->desc              = $faker->unique()->text( $maxNbChars = 80 );
		$job->day_rate          = 150;
		$job->application_start = Carbon::now()->format( 'Y-m-d' );
		$rand_days              = rand( 1, 10 );
		$job->application_end   = Carbon::now()->addDays( $rand_days )->format( 'Y-m-d' );
		$job->job_start         = Carbon::now()->addDays( $rand_days )->format( 'Y-m-d' );
		$job->job_end           = Carbon::now()->addDays( rand( 1, 10 ) + $rand_days )->format( 'Y-m-d' );
		$job->working_time_from = Carbon::now()->format( 'h:i' );
		$job->working_time_to   = Carbon::now()->addHours( rand( 1, 8 ) )->format( 'h:i' );
		$job->completed         = FALSE;
		$job->save();
		
		/*Dodeljene L1 jobs P2*/
		$job                    = new Job;
		$job->practice_id       = 1;
		$job->user_id           = NULL;
		$job->title             = $faker->unique()->text( $maxNbChars = 35 );
		$job->desc              = $faker->unique()->text( $maxNbChars = 80 );
		$job->day_rate          = 150;
		$job->application_start = Carbon::now()->format( 'Y-m-d' );
		$rand_days              = rand( 1, 10 );
		$job->application_end   = Carbon::now()->addDays( $rand_days )->format( 'Y-m-d' );
		$job->job_start         = Carbon::now()->addDays( $rand_days )->format( 'Y-m-d' );
		$job->job_end           = Carbon::now()->addDays( rand( 1, 10 ) + $rand_days )->format( 'Y-m-d' );
		$job->working_time_from = Carbon::now()->format( 'h:i' );
		$job->working_time_to   = Carbon::now()->addHours( rand( 1, 8 ) )->format( 'h:i' );
		$job->completed         = FALSE;
		$job->save();
		/*aplikacija za job*/
		$application          = new Application;
		$application->user_id = 1;
		$application->job_id  = 2;
		$application->desc    = $faker->unique()->text( $maxNbChars = 80 );
		$application->save();
	
		
		
		/*Komplitovan L1 jobs za P2*/
		
		$invoice                = new Invoice;
		$invoice->practice_id   = 1;
		$invoice->user_id       = 1;
		$invoice->paypal_name   = $faker->unique()->text( $maxNbChars = 15 );
		$invoice->payment_terms = Constant::PAYMENT_TERMS;
		$invoice->sent          = 0;
		$invoice->save();
		
		$job                    = new Job;
		$job->practice_id       = 1;
		$job->user_id           = 1;
		$job->title             = $faker->unique()->text( $maxNbChars = 35 );
		$job->desc              = $faker->unique()->text( $maxNbChars = 80 );
		$job->day_rate          = 150;
		$job->application_start = Carbon::now()->format( 'Y-m-d' );
		$rand_days              = rand( 1, 10 );
		$job->application_end   = Carbon::now()->addDays( $rand_days )->format( 'Y-m-d' );
		$job->job_start         = Carbon::now()->addDays( $rand_days )->format( 'Y-m-d' );
		$job->job_end           = Carbon::now()->addDays( rand( 1, 10 ) + $rand_days )->format( 'Y-m-d' );
		$job->working_time_from = Carbon::now()->format( 'h:i' );
		$job->working_time_to   = Carbon::now()->addHours( rand( 1, 8 ) )->format( 'h:i' );
		$job->invoice_id        = 1;
		$job->completed         = TRUE;
		$job->save();
		
		/*aplikacija za komplitovan job*/
		$application          = new Application;
		$application->user_id = 1;
		$application->job_id  = 3;
		$application->desc    = $faker->unique()->text( $maxNbChars = 80 );
		$application->save();
		/*feedback za komplitovan job*/
		$feedback          = new Feedback;
		$feedback->user_id = 1;
		$feedback->job_id  = 3;
		$feedback->content = $faker->text( $maxNbChars = 555 );
		$feedback->rating  = rand( 1, 5 );
		$feedback->save();
		
		$feedback          = new Feedback;
		$feedback->user_id = 2;
		$feedback->job_id  = 3;
		$feedback->content = $faker->text( $maxNbChars = 555 );
		$feedback->rating  = rand( 1, 5 );
		$feedback->save();
		
		$pdf = \PDF::loadView( 'email.invoice', [
			'jobs'     => [$job],
			'invoice'  => $invoice,
			'practice' => Practice::find( $job->practice_id ),
			'user'     => User::find( $job->user_id ),
		] );
		
		Storage::put( $invoice->id . '_invoices.pdf', $pdf->output() );
		
	
		
		/*Job sa procentima L1 jobs za P2*/
		$job                    = new Job;
		$job->practice_id       = 1;
		$job->user_id           = 1;
		$job->title             = $faker->unique()->text( $maxNbChars = 35 );
		$job->desc              = $faker->unique()->text( $maxNbChars = 80 );
		$job->percentage        = 20;
		$job->application_start = Carbon::now()->format( 'Y-m-d' );
		$rand_days              = rand( 1, 10 );
		$job->application_end   = Carbon::now()->addDays( $rand_days )->format( 'Y-m-d' );
		$job->job_start         = Carbon::now()->addDays( $rand_days )->format( 'Y-m-d' );
		$job->job_end           = Carbon::now()->addDays( rand( 1, 10 ) + $rand_days )->format( 'Y-m-d' );
		$job->working_time_from = Carbon::now()->format( 'h:i' );
		$job->working_time_to   = Carbon::now()->addHours( rand( 1, 8 ) )->format( 'h:i' );
		$job->completed         = FALSE;
		$job->save();
		
		/*aplikacija za job sa procentima*/
		$application          = new Application;
		$application->user_id = 1;
		$application->job_id  = 4;
		$application->desc    = $faker->unique()->text( $maxNbChars = 80 );
		$application->save();
		
		$job->job_start = Carbon::parse( $job->job_start );
		$job->job_end   = Carbon::parse( $job->job_end );
		$job->job_end->addDay();
		$step   = CarbonInterval::day();
		$period = new DatePeriod( $job->job_start, $step, $job->job_end );
		
		$range = collect( [] );
		
		foreach($period as $day) {
			$singleDay = new Carbon( $day );
			$singleDay = Carbon::parse( $singleDay )->format( 'Y-m-d' );
			$range->push( $singleDay );
			$percentages      = new Percentage;
			$percentages->day = $singleDay;
			
			$percentages->job()->associate( $job );
			$percentages->save();
		}
		
		
		/*Job sa procentima L1 jobs za P2*/
		
		$invoice                = new Invoice;
		$invoice->practice_id   = 1;
		$invoice->user_id       = 1;
		$invoice->paypal_name   = $faker->unique()->text( $maxNbChars = 15 );
		$invoice->payment_terms = Constant::PAYMENT_TERMS;
		$invoice->sent          = 0;
		$invoice->save();
		
		$job                    = new Job;
		$job->practice_id       = 1;
		$job->user_id           = 1;
		$job->title             = $faker->unique()->text( $maxNbChars = 35 );
		$job->desc              = $faker->unique()->text( $maxNbChars = 80 );
		$job->percentage        = 20;
		$job->application_start = Carbon::now()->format( 'Y-m-d' );
		$rand_days              = rand( 1, 10 );
		$start_date             = Carbon::now()->addDays( $rand_days );
		$job->application_end   = $start_date->format( 'Y-m-d' );
		$job->job_start         = $start_date->format( 'Y-m-d' );
		$end_date               = Carbon::now()->addDays( rand( 1, 10 ) + $rand_days );
		$job->job_end           = $end_date->format( 'Y-m-d' );
		$job->working_time_from = Carbon::now()->format( 'h:i' );
		$job->working_time_to   = Carbon::now()->addHours( rand( 1, 8 ) )->format( 'h:i' );
		$job->invoice_id        = 2;
		$job->current_income    = ($end_date->diffInDays( $start_date ) + 1) * 100;
		$job->completed         = TRUE;
		$job->save();
		
		/*aplikacija za job sa procentima*/
		$application          = new Application;
		$application->user_id = 1;
		$application->job_id  = 5;
		$application->desc    = $faker->unique()->text( $maxNbChars = 80 );
		$application->save();
		
		$job->job_start = Carbon::parse( $job->job_start );
		$job->job_end   = Carbon::parse( $job->job_end );
		$job->job_end->addDay();
		$step   = CarbonInterval::day();
		$period = new DatePeriod( $job->job_start, $step, $job->job_end );
		
		$range = collect( [] );
		
		foreach($period as $day) {
			$singleDay = new Carbon( $day );
			$singleDay = Carbon::parse( $singleDay )->format( 'Y-m-d' );
			$range->push( $singleDay );
			$percentages         = new Percentage;
			$percentages->amount = 100;
			$percentages->day    = $singleDay;
			
			$percentages->job()->associate( $job );
			$percentages->save();
		}
		
		$feedback          = new Feedback;
		$feedback->user_id = 1;
		$feedback->job_id  = 5;
		$feedback->content = $faker->text( $maxNbChars = 555 );
		$feedback->rating  = rand( 1, 5 );
		$feedback->save();
		
		$feedback          = new Feedback;
		$feedback->user_id = 2;
		$feedback->job_id  = 5;
		$feedback->content = $faker->text( $maxNbChars = 555 );
		$feedback->rating  = rand( 1, 5 );
		$feedback->save();
		
		$pdf = \PDF::loadView( 'email.invoice', [
			'jobs'     => [$job],
			'invoice'  => $invoice,
			'practice' => Practice::find( $job->practice_id ),
			'user'     => User::find( $job->user_id ),
		] );
		
		Storage::put( $invoice->id . '_invoices.pdf', $pdf->output() );
		
	}
}
