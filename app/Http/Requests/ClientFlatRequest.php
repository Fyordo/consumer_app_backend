<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientFlatRequest extends FormRequest
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
            'client_id' => 'integer|required',
            'flat_id' => 'integer|required',
            'client_flat_status_id' => 'integer|required',
        ];
    }
}
