<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * FlatStatus
 *
 * @OA\Schema(
 *      schema="FlatStatus",
 *      type="object",
 *      @OA\Property(
 *          property="id",
 *          description="Идентификатор статуса квартиры",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="title",
 *          description="Название статуса квартиры",
 *          type="string"
 *      )
 *  )
 *
 * @package App\Models\FlatStatus
 */

class FlatStatusResource extends JsonResource
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
            'title' => $this->title
        ];
    }
}
