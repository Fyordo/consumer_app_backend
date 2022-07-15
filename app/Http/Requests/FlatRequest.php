<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlatRequest extends FormRequest
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
            'title' => 'string|required',
            'status_id' => 'integer|required',
            'full_space' => 'float|required',
            'floor_count' => 'integer|required',
            'living_space' => 'float|required',
            'room_count' => 'integer|required',
            'balconyless_space' => 'float|required',
            'residential_complex_id' => 'integer|required',
            'cost' => 'integer',
            'is_ready' => 'boolean',
        ];
    }
}
