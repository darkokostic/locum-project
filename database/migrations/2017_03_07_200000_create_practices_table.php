<?php
use App\Helpers\Constant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePracticesTable
 */
class CreatePracticesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		
		Schema::create( 'practices', function( Blueprint $table ) {
			
			$table->increments( 'id' );
			$table->string( 'practice_name' );
			$table->string( 'practice_email' );
			$table->string( 'practice_address1' );
			$table->string( 'practice_address2' )->nullable();
			$table->string( 'practice_city' );
			$table->string( 'practice_province' );
			$table->string( 'practice_postal_code' );
			$table->string('avatar')->default(Constant::PRACTICE_DEFAULT_AVATAR_PATH);
			$table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
			$table->string( 'practice_phone', 50 );
			$table->string( 'practice_website' )->nullable();
			$table->string( 'practice_facebook' )->nullable();
			$table->text( 'overview' )->nullable();
			$table->string( 'no_of_exam_lanes' )->nullable()->default(NULL);
			$table->string( 'no_of_staff' )->default(NULL);
			$table->string( 'sq_ft' )->nullable()->default(NULL);
			$table->enum( 'experience_requirement', Constant::ExperienceRequirement )->nullable()->default(NULL);
			$table->integer( 'day_rate' )->nullable();
			$table->string( 'pretest_equipment' )->nullable()->default(NULL);
			$table->string( 'specialist_equipment' )->nullable()->default(NULL);
			$table->string( 'practice_specialty' )->nullable()->default(NULL);
			$table->string( 'practice_management_system' )->nullable()->default(NULL);
			$table->string( 'lens_product_affiliation' )->nullable()->default(NULL);
			$table->string( 'contact_lens_specialty' )->nullable()->default(NULL);
			$table->enum( 'average_full_exam_time', Constant::AverageFullExamTime )->nullable()->default(NULL);
			$table->boolean( 'handover_between' )->nullable()->default(NULL);
			$table->enum( 'patient_booking_preference', Constant::PatientBookingPreference )->nullable()->default(NULL);
			$table->boolean( 'practice_visible' )->default( FALSE );
			 $table->bigInteger('radius')->default(100000);
			$table->integer( 'user_id' )->unsigned()->nullable();
			$table->integer('corporation_id')->unsigned()->nullable();
			$table->rememberToken();
			$table->softDeletes();
			$table->timestamps();
		} );
		
		Schema::table( 'practices', function( Blueprint $table ) {
			$table->index( 'practice_name' );
			$table->index( 'practice_city' );
			$table->index( 'user_id' );
			$table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
            $table->foreign( 'corporation_id' )->references( 'id' )->on( 'corporations' )->onDelete( 'cascade' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		
		Schema::dropIfExists( 'practices' );
	}
}
