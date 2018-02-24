<?php

namespace App\Http\Requests\Job;

use App\Helpers\Constant;
use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class DeleteJobRequest
 * @package App\Http\Requests\Job
 */
class DeleteJobRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		try {
			if(!$user = JWTAuth::parseToken()->authenticate()) {
				return FALSE;
			}
		} catch(\Exception $e) {
			return FALSE;
		}
		$job = $this->route( 'job' );
		
		return $job && $user && $user->can( 'delete', $job, Constant::JOB_IDENTIFIERS );
	}
	
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [//
		];
	}
	
	
}
