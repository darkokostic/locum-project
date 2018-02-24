<?php

namespace App\Http\Requests\Calendar;

use App\Helpers\Constant;
use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class CreateCalendarRequest
 * @package App\Http\Requests\Calendar
 */
class CreateCalendarRequest extends FormRequest {
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
		
		return $user->can( 'create', Constant::CALENDAR_IDENTIFIERS );
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'start_date' => 'required|date|after_or_equal:today',
			'end_date'   => 'required|date|after_or_equal:today',
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
