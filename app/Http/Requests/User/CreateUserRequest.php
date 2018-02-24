<?php
namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateUserRequest
 * @package App\Http\Requests\User
 */
class CreateUserRequest extends FormRequest {

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
            'name'                       => 'required|max:255',
            'email'                      => 'required|email|unique:users,email',
            'password'                   => 'required|max:255',  //ToDo Add password confirmation rules
            'role'                       => 'sometimes|in:ROLE_USER,ROLE_STAFF,ROLE_ADMIN',
            'address1'                   => 'required|max:255',
            'province'                   => 'required|max:255',
            'postal_code'                => 'required|min:6|max:6',
            'phone'                      => 'required|min:10|max:10',
            'website'                    => 'max:255',
            'linkedin'                   => 'max:255',
            'graduated_year'             => 'required',
            'day_rate'                   => 'max:255',
            'radius'                     => 'required',
            'visible'                    => 'required|boolean',
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