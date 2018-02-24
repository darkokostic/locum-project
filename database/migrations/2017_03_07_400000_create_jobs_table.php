<?php
use App\Helpers\Constant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration {
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		
		Schema::create( 'jobs', function( Blueprint $table ) {
			
			$table->increments( 'id' );
			$table->integer( 'practice_id' )->unsigned();
			$table->integer( 'user_id' )->unsigned()->nullable();
			$table->string( 'title' )->nullable();
			$table->text( 'desc' )->nullable();
			$table->integer( 'day_rate' )->nullable();
			$table->integer( 'percentage' )->nullable();
			$table->date( 'application_start' );
			$table->date( 'application_end' );
			$table->date( 'job_start' );
			$table->date( 'job_end' );
			$table->string( 'working_time_from' )->nullable();
			$table->string( 'working_time_to' )->nullable();
			$table->string( 'current_income' )->nullable();
            $table->integer('invoice_id')->unsigned()->nullable()->default(null);
			$table->boolean( 'completed' )->default(FALSE);
			$table->boolean( 'locumRated' )->default(FALSE);
			$table->boolean( 'practiceRated' )->default(FALSE);
			$table->softDeletes();
			$table->timestamps();
		} );
		
		Schema::table( 'jobs', function( Blueprint $table ) {
			$table->index('practice_id');
			$table->index('user_id');
			$table->index('job_start');
			$table->index('job_end');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign( 'practice_id' )->references( 'id' )->on( 'practices' )->onDelete( 'cascade' );
			$table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::dropIfExists( 'jobs' );
	}
}
