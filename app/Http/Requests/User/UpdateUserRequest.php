<?php

namespace App\Http\Requests\User;

use App\Helpers\Constant;
use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class UpdateUserRequest
 * @package App\Http\Requests\User
 */
class UpdateUserRequest extends FormRequest {
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
		$locum = $this->route( 'locum' );
		
		return $locum && $user && $user->can( 'update', $locum );
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'name'                       => 'max:255',
			'email'                      => 'email',
			'password'                   => 'max:255',
			'role'                       => 'sometimes|in:ROLE_USER,ROLE_STAFF,ROLE_ADMIN',
			'address1'                   => 'max:255',
			'province'                   => 'max:255',
			'postal_code'                => 'min:6|max:6',
			'phone'                      => 'min:10|max:10',
			'website'                    => 'max:255',
			'linkedin'                   => 'max:255',
			'day_rate'                   => 'integer',
			'visible'                    => 'boolean',
			'radius'					 => 'max:255',
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
