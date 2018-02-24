<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Practice
 * @package App
 */
class Practice extends Model {
	
	use SoftDeletes;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'practice_name',
		'practice_email',
		'practice_address1',
		'practice_address2',
		'practice_city',
		'practice_province',
		'practice_postal_code',
		'lat',
		'lng',
		'practice_phone',
		'practice_website',
		'practice_facebook',
		'overview',
		'no_of_exam_lanes',
		'no_of_staff',
		'sq_ft',
		'experience_requirement',
		'day_rate',
		'pretest_equipment',
		'specialist_equipment',
		'practice_specialty',
		'practice_management_system',
		'lens_product_affiliation',
		'contact_lens_specialty',
		'average_full_exam_time',
		'handover_between',
		'patient_booking_preference',
		'practice_visible',
        'corporation_id'
	];
    protected $appends = [ 'invoices'];
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		return $this->belongsTo( 'App\User' );
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function invoices() {
		return $this->hasMany( 'App\Invoice' );
	}
	public function finishedInvoices(){
	    return $this->invoices()->where('sent',1)->get();
    }
	public function getInvoicesAttribute(){
	    return $this->invoices()->get();
    }
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function payments_options() {
		
		return $this->hasMany( 'App\PaymentsOptions' );
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function jobs() {
		
		return $this->hasMany( 'App\Job' );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function finished_jobs() {
		return $this->jobs()->where('completed', true);
	}

	public function getTotalEarningsAttribute() {
		$total = 0;
		$this->finished_jobs->each(function(Job $job) use (&$total) {
            $total += $job->total;
        });
        return $total;
	}

    public function corporation() {
        return $this->belongsTo( 'App\Corporation' );
    }
	
}
