<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ResidentialComplexRequest
 *
 * @OA\Schema(
 *      schema="ResidentialComplexRequest",
 *      type="object",
 *      @OA\Property(
 *          property="title",
 *          description="Название ЖК",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="address",
 *          description="Адрес ЖК",
 *          type="string"
 *      )
 *  )
 *
 * @package App\Requests\ResidentialComplexRequest
 */

class ResidentialComplexRequest extends FormRequest
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
            'title' => "string|required",
            'address' => "string|required"
        ];
    }
}
