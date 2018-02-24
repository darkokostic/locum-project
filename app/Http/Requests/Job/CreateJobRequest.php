<?php

namespace App\Http\Requests\Job;

use App\Helpers\Constant;
use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class CreateJobRequest
 * @package App\Http\Requests\Job
 */
class CreateJobRequest extends FormRequest {
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
		
		return $user->can( 'create', Constant::JOB_IDENTIFIERS );
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'application_start' => 'required|date|after_or_equal:today',
			'application_end'   => 'required|date|after_or_equal:today',
			'job_start'         => 'required|date|after_or_equal:today',
			'job_end'           => 'required|date|after_or_equal:today',
			'working_time_from' => 'required',
			'working_time_to'   => 'required',
			'active'            => 'boolean',
		];
	}
    /**
     * @param array $errors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function response( array $errors ) {

        return response()->json( [
            'errors' => $errors,
        ], 400 );
    }
	
}
