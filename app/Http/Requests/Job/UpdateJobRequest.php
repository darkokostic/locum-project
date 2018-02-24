<?php

namespace App\Http\Requests\Job;

use App\Helpers\Constant;
use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class UpdateJobRequest
 * @package App\Http\Requests\Job
 */
class UpdateJobRequest extends FormRequest {
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
		
		return $job && $user && $user->can( 'update', $job, Constant::JOB_IDENTIFIERS );
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'application_start' => 'date',
			'application_end'   => 'date',
			'job_start'         => 'date',
			'job_end'           => 'date',
		];
	}
	
}
