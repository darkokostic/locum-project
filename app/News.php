<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;
	
	protected $fillable = [
		'title',
		'content',
		'for_locum',
		'for_practice',
		'url',
        'avatar'
	];
	public $timestamps = true;
}
