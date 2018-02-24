<?php

namespace App\Http\Requests\Practice;

use App\Helpers\Constant;
use App\Practice;
use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class PracticeDashboardRequest extends FormRequest {
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
		$practice = Practice::where('user_id' , $user->id)->first();
		return $user && $user->can( 'dashboard' , $practice);
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
