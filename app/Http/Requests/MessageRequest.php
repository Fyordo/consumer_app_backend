<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * MessageRequest
 *
 * @OA\Schema(
 *      schema="MessageRequest",
 *      type="object",
 *      @OA\Property(
 *          property="user_id",
 *          description="Идентификатор пользователя",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="message",
 *          description="Сообщение",
 *          type="string"
 *      )
 *  )
 *
 * @package App\Requests\MessageRequest
 */

class MessageRequest extends FormRequest
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
            'user_id' => 'required',
            'message' => 'required'
        ];
    }
}
