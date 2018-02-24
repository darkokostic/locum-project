<?php

namespace App\Http\Requests\Payments;

use App\Helpers\Constant;
use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class ViewPaymentsRequest
 * @package App\Http\Requests\Payments
 */
class ViewPaymentsRequest extends FormRequest {
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
		$payment = $this->route( 'payment' );
		
		return $payment && $user && $user->can( 'view', $payment, Constant::PAYMENTS_OPTIONS_IDENTIFIERS );
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
