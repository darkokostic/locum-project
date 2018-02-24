<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePercentagesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'percentages', function( Blueprint $table ) {
			$table->increments( 'id' );
			$table->unsignedInteger( 'job_id' );
			$table->integer( 'amount' )->default(0);
			$table->string( 'day' );
			$table->boolean( 'isSent' )->default( FALSE );
			$table->boolean( 'approved' )->default( FALSE );
			$table->softDeletes();
			$table->timestamps();
		} );
		Schema::table( 'percentages', function( Blueprint $table ) {
			$table->foreign( 'job_id' )->references( 'id' )->on( 'jobs' )->onDelete( 'cascade' );
		} );
	}
	
	
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'percentages' );
	}
}
