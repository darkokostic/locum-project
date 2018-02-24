<?php

namespace App\Http\Requests\Practice;

use App\Helpers\Constant;
use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdatePracticeRequest extends FormRequest {
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
		
		$practice = $this->route( 'practice' );
		
		return $practice && $user && $user->can( 'update', $practice);
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'practice_name'        => 'max:255',
			'practice_email'       => 'email',
			'email'                => 'email',
			'password'             => 'max:255',
			'practice_address1'    => 'max:255',
			'practice_province'    => 'max:255',
			'practice_postal_code' => 'min:6|max:6',
			'practice_city'        => 'max:255',
			'practice_phone'       => 'min:10|max:10',
			'practice_visible'     => 'boolean',
			'postal_code'          => 'min:6|max:6',
		];
	}
}
