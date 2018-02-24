<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model {
	use SoftDeletes;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'paypal_name',
		'payment_terms',
		'sent',
		'paid_status',
		'practice_id',
		'user_id',
        'corporation_id',
	];
/*	protected $appends  = ['job'];
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
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function job() {
		
		return $this->hasOne( 'App\Job' );
	}
	
/*	public function getJobAttribute() {
		return $this->job()->get();
	}*/
}
