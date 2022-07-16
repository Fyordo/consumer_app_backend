<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ClientFlatRequest
 *
 * @OA\Schema(
 *      schema="ClientFlatRequest",
 *      type="object",
 *      @OA\Property(
 *          property="client_id",
 *          description="Идентификатор клиента",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="flat_id",
 *          description="Идентификатор квартиры",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="client_flat_status_id",
 *          description="Идентификатор статуса связки клиент-квартира",
 *          type="integer"
 *      )
 *  )
 *
 * @package App\Requests\ClientFlatRequest
 */

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
