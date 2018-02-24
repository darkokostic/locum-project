<?php

namespace App\Http\Requests\News;

use App\Helpers\Constant;
use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdateNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		try {
			if(!$user = session('user')) {
				return FALSE;
			}
		} catch(\Exception $e) {
			return FALSE;
		}
		//$news = $this->route( 'news' );
		//return $news && $user && $user->can( 'update', $news, Constant::NEWS_IDENTIFIERS );
        return true;
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
