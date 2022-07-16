<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * FlatRequest
 *
 * @OA\Schema(
 *      schema="FlatRequest",
 *      type="object",
 *      @OA\Property(
 *          property="title",
 *          description="Название квартиры",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="status_id",
 *          description="Идентификатор статуса квартиры",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="full_space",
 *          description="Вся площадь",
 *          type="float"
 *      ),
 *      @OA\Property(
 *          property="floor_count",
 *          description="Кол-во этажей",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="living_space",
 *          description="Жилая площадь",
 *          type="float"
 *      ),
 *      @OA\Property(
 *          property="room_count",
 *          description="Кол-во комнат",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="balconyless_space",
 *          description="Площадьь без балконов и т.п.",
 *          type="float"
 *      ),
 *      @OA\Property(
 *          property="residential_complex_id",
 *          description="Идентификатор ЖК, в котором располагается квартира",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="cost",
 *          description="Начальная цена квартиры",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="is_ready",
 *          description="Готова ли квартира",
 *          type="boolean"
 *      )
 *  )
 *
 * @package App\Requests\FlatRequest
 */

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
