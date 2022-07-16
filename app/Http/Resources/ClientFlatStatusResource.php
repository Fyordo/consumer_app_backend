<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * ClientFlatStatus
 *
 * @OA\Schema(
 *      schema="ClientFlatStatus",
 *      type="object",
 *      @OA\Property(
 *          property="id",
 *          description="Идентификатор статуса связки клиент-квартира",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="title",
 *          description="Название статуса связки клиент-квартира",
 *          type="string"
 *      )
 *  )
 *
 * @package App\Models\ClientFlatStatus
 */

class ClientFlatStatusResource extends JsonResource
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
            'title' => $this->title,
        ];
    }
}
