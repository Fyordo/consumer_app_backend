<?php

namespace App\Http\Resources;

use App\Models\ClientFlatStatus;
use Illuminate\Http\Resources\Json\JsonResource;

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
