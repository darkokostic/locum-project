<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class GetInvoicePDF extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'id' => 'required'
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
