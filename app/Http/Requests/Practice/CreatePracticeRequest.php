<?php
namespace App\Http\Requests\Practice;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreatePracticeRequest
 * @package App\Http\Requests\Practice
 */
class CreatePracticeRequest extends FormRequest {
	
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		
		return TRUE;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		
		return [
			'practice_name'        => 'required|max:255',
			'practice_email'       => 'required|email',
			'email'                => 'required|email|unique:users,email',
			'password'             => 'required|max:255',
			'practice_address1'    => 'required|max:255',
			'practice_province'    => 'required|max:255',
			'practice_postal_code' => 'required|min:6|max:6',
			'practice_city'        => 'required|max:255',
			'practice_phone'       => 'required|min:10|max:10',
			'practice_visible'     => 'required|boolean',
			'postal_code'          => 'required|min:6|max:6',
			'city'                 => 'required',
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
