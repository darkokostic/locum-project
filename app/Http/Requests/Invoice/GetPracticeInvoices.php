<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class GetPracticeInvoices extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		try {
			if(!$user = JWTAuth::parseToken()->authenticate()) {
				return FALSE;
			} else {
				$this->request->add( ['user' => $user] );
			}
		} catch(\Exception $e) {
			return FALSE;
		}
		
		return TRUE;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'job_start' => 'date',
			'job_end'   => 'date',
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
