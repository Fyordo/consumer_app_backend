<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Feature
 *
 * @OA\Schema(
 *      schema="Feature",
 *      type="object",
 *      @OA\Property(
 *          property="id",
 *          description="Идентификатор клиента",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="count_request",
 *          description="Кол-во запросов",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="title",
 *          description="Название",
 *          type="integer"
 *      )
 *  )
 *
 * @package App\Models\Feature
 */

class FeatureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'count_request' => $this->count_request,
            'title' => $this->title,
        ];
    }
}
