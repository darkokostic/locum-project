<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model {
	use SoftDeletes;
	
	protected $fillable = ['job_id', 'content' , 'rating' , 'user_id'];
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function job() {
		return $this->hasOne( 'App\Job' );
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		return $this->belongsTo( 'App\User' );
	}
}
