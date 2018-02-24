<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoicesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$faker = Faker\Factory::create();
		for($i = 1; $i <= 5; $i++) {
			DB::table( 'invoices' )->insert( [
				'practice_id'   => rand( 1, 2 ),
				'user_id'       => 1,
				'paypal_name'   => $faker->unique()->text( $maxNbChars = 8 ),
				'payment_terms' => \App\Helpers\Constant::PAYMENT_TERMS,
				'sent'          => 0,
				'created_at'    => Carbon::now()->subMinute(),
			] );
		}
	}
}
