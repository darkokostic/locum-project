<?php

namespace App\Http\Requests\Payments;

use App\Helpers\Constant;
use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class CreatePaymentsRequest
 * @package App\Http\Requests\Payments
 */
class CreatePaymentsRequest extends FormRequest {
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
		return $user->can( 'create', Constant::PAYMENTS_OPTIONS_IDENTIFIERS );
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'card_number'           => 'required',
			'card_expiry_month'     => 'required',
			'card_expiry_year'      => 'required',
			'cvv2'                  => 'required',
			'card_type'             => 'required',
			'cardholder_first_name' => 'required',
			'cardholder_last_name'  => 'required',
		];
	}
}
