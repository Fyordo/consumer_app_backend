<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * SendMessageRequest
 *
 * @OA\Schema(
 *      schema="SendMessageRequest",
 *      type="object",
 *      @OA\Property(
 *          property="message",
 *          description="Сообщение",
 *          type="string"
 *      )
 *  )
 *
 * @package App\Requests\SendMessageRequest
 */

class SendMessageRequest extends FormRequest
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
            'message' => 'string|required',
        ];
    }
}
