<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $faker = Faker\Factory::create();
        for ($i = 0; $i <= 100; $i++) {
            DB::table('applications')->insert([
                'user_id' => rand(1, 10),
                'job_id'     => rand(4, 40),
                'desc'    => $faker->unique()->text($maxNbChars = 50),
                'created_at'  => Carbon::now()->subMinutes(rand(0, 60)),
            ]);
        }
    }
}
