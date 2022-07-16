<?php

namespace App\Http\Resources;

use App\Models\ClientFlatStatus;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 * ClientFlat
 *
 * @OA\Schema(
 *      schema="ClientFlat",
 *      type="object",
 *      @OA\Property(
 *          property="id",
 *          description="Идентификатор связки клиент-квартира",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="client",
 *          description="Клиент",
 *          type="object",
 *          ref="#/components/schemas/Client"
 *      ),
 *      @OA\Property(
 *          property="flat",
 *          description="Квартира",
 *          type="object",
 *          ref="#/components/schemas/Flat"
 *      ),
 *      @OA\Property(
 *          property="client_flat_status",
 *          description="Статус связки клиент-квартира",
 *          type="object",
 *          ref="#/components/schemas/ClientFlatStatus"
 *      )
 *  )
 *
 * @package App\Models\ClientFlat
 */

class ClientFlatResource extends JsonResource
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
            'client' => $this->when($this->client, new ClientResource($this->client)),
            'flat' => $this->when($this->flat, new FlatResource($this->flat)),
            'client_flat_status' => $this->when($this->client_flat_status, new ClientFlatStatusResource($this->client_flat_status)),
        ];
    }
}
