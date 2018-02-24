<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Percentage extends Model {
	
	use SoftDeletes;
	
	protected $fillable = ['amount'];
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function job() {
		
		return $this->belongsTo( 'App\Job' );
	}
}
