<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'feedback', function( Blueprint $table ) {
			$table->increments( 'id' );
			$table->integer( 'user_id' )->unsigned()->nullable();
			$table->integer( 'job_id' )->unsigned()->nullable();
			$table->text( 'content' )->nullable();
			$table->integer( 'rating' )->nullable();
			$table->softDeletes();
			$table->timestamps();
		} );
		
		Schema::table( 'feedback', function( Blueprint $table ) {
			$table->index('user_id');
			$table->index('job_id');
			$table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
			$table->foreign( 'job_id' )->references( 'id' )->on( 'jobs' )->onDelete( 'cascade' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'feedback' );
	}
}
