<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		//$this->call( CorporationTableSeeder::class );
		$this->call( ProdSeeder::class );
		
		// $this->call( UsersTableSeeder::class );
		
		// $this->call( PracticesTableSeeder::class );
		// $this->call( NewsTableSeeder::class );

		// $this->call( InvoicesTableSeeder::class );
		// $this->call( JobsTableSeeder::class );
		// $this->call(ApplicationsTableSeeder::class);
		// $this->call( CalendarsTableSeederder::class );
		// $this->call(FeedbackTableSeeder::class);
		
	}
}
