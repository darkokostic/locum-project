<?php

namespace App\Http\Requests\Calendar;

use App\Helpers\Constant;
use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class DeleteCalendarRequest
 * @package App\Http\Requests\Calendar
 */
class DeleteCalendarRequest extends FormRequest {
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
		
		$calendar = $this->route( 'calendar' );
		
		return $calendar && $user && $user->can( 'delete', $calendar, Constant::CALENDAR_IDENTIFIERS );
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [];
	}
}
