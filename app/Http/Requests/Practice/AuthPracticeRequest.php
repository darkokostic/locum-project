<?php
namespace App\Http\Requests\Practice;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AuthPracticeRequest
 * @package App\Http\Requests\Practice
 */
class AuthPracticeRequest extends FormRequest {

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
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|max:255',
        ];
    }

    /**
     * @param array $errors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $errors) {

        return response()->json([
            'errors' => $errors,
        ], 400);
    }

}
