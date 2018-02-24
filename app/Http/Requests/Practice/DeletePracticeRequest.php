<?php

namespace App\Http\Requests\Practice;

use App\Helpers\Constant;
use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class DeletePracticeRequest
 * @package App\Http\Requests\Practice
 */
class DeletePracticeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
	public function authorize() {
		try {
			if (!$user = JWTAuth::parseToken()->authenticate()) {
				return false;
			}
		} catch (\Exception $e) {
			return false;
		}
		$practice = $this->route('practice');
		return $practice && $user && $user->can('delete', Constant::PRACTICE_IDENTIFIERS);
	}


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
