<?php
use App\Helpers\Constant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersTable
 */
class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('users', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', [Constant::ROLE_OWNER,  Constant::ROLE_USER , Constant::ROLE_ADMIN])->default(Constant::ROLE_USER);
			$table->string('avatar')->default(Constant::LOCUM_DEFAULT_AVATAR_PATH);
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('province')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->string('postal_code');
            $table->string('phone', 50)->nullable();
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->integer('graduated_year')->nullable();
            $table->integer('day_rate')->default(10)->nullable();
            $table->string('specialist_equipment')->nullable()->default(NULL);
            $table->string('locum_specialty')->nullable()->default(NULL);
            $table->string('practice_management_system')->nullable()->default(NULL);
            $table->string('lens_product_knowledge')->nullable()->default(NULL);
            $table->string('contact_lens_specialty')->nullable()->default(NULL);
            $table->enum('average_full_exam_time', Constant::AverageFullExamTime)->nullable()->default(NULL);
            $table->boolean('handover_between')->nullable()->default(NULL);
            $table->enum('patient_booking_preference', Constant::PatientBookingPreference)->nullable()->default(NULL);;
            $table->text('overview')->nullable();
            $table->bigInteger('radius')->default(100000);
            $table->boolean('visible')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::dropIfExists('users');
    }
}
