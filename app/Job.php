<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class Job
 * @package App
 */
class Job extends Model {
	
	use SoftDeletes;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'desc',
		'day_rate',
		'percentage',
		'application_start',
		'application_end',
		'job_start',
		'job_end',
		'working_time_from',
		'working_time_to',
		'contract',
		'invoice_id',
		'user_id',
		'completed',
	];
	
	protected $appends = [
		'total',
		'locumTotal',
		'totalDays',
		'isApplicationExpired',
		'isApplied',
		'canFinish'
	];
	
	protected $casts = [
		'current_income' => 'integer',
		'completed' => 'boolean'
	];
	
	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at',
	];
	
/*	protected $casts = [
		'percentage' => 'boolean',
	];
	*/
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		
		return $this->belongsTo( 'App\User' );
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function practice() {
		
		return $this->belongsTo( 'App\Practice' );
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function invoice() {
		return $this->belongsTo( 'App\Invoice' );
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function applications() {
		
		return $this->hasMany( 'App\Application', 'job_id', 'id' );
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function percentages() {
		
		return $this->hasMany( 'App\Percentage' );
	}
	
	public function getPercentagesAttribute() {
		return $this->percentages()->get();
	}
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	/*	public function application() {
			
			return $this->belongsTo( 'App\Application');
		}*/
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function feedback() {
		
		return $this->hasOne( 'App\Feedback' );
	}
	
	public function getTotalAttribute() {
		if($this->day_rate != NULL) {
			$this->job_start = Carbon::parse( $this->job_start );
			$this->job_end   = Carbon::parse( $this->job_end );
			
			return (integer)$this->job_end->diffInDays( $this->job_start ) * $this->day_rate;
		} else {
			return (integer)$this->current_income;
		}
	}
	
	public function getTotalDaysAttribute() {
		$this->job_start = Carbon::parse( $this->job_start );
		$this->job_end   = Carbon::parse( $this->job_end );
		
		return (integer)$this->job_end->diffInDays( $this->job_start );
	}
	
	public function getIsApplicationExpiredAttribute() {
		if(Carbon::now()->format( 'Y-m-d' ) <= Carbon::createFromFormat( 'Y-m-d', $this->application_end )->format( 'Y-m-d' )) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	public function getIsAppliedAttribute(){
		try {
			$user = JWTAuth::parseToken()->authenticate();
		} catch(TokenExpiredException $e) {
			return false;
		} catch(TokenInvalidException $e) {
			return false;
		} catch(JWTException $e) {
			return false;
		} catch(\Exception $e) {
			return false;
		}
		
		if((Application::where('user_id' , $user->id )->where('job_id' , $this->id)->first()) != NULL){
			return true;
		}else{
			return false;
		}
	}
	
	public function getLocumTotalAttribute(){
		return 	($this->percentage / 100) * $this->current_income;
	}
	
	public function getCanFinishAttribute(){
		if(Carbon::now() <=  $this->job_end ) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
}
