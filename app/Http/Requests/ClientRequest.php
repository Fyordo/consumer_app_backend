<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ClientRequest
 *
 * @OA\Schema(
 *      schema="ClientRequest",
 *      type="object",
 *      @OA\Property(
 *          property="name",
 *          description="ФИО клиента",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="email",
 *          description="Почта клиента",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="phone",
 *          description="Телефон клиента",
 *          type="string"
 *      )
 *  )
 *
 * @package App\Requests\ClientRequest
 */

class ClientRequest extends FormRequest
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
            'name' => 'string|required',
            'phone' => 'string|required',
            'email' => 'string|required'
        ];
    }
}
