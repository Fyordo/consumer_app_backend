<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FlatResource extends JsonResource
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
            'status' => $this->when($this->status, new FlatStatusResource($this->status)), // TODO
            'full_space' => $this->full_space,
            'floor_count' => $this->floor_count,
            'living_space' => $this->living_space,
            'room_count' => $this->room_count,
            'balconyless_space' => $this->balconyless_space,
            'residential_complex_id' => $this->residential_complex_id,
            'cost' => $this->cost,
        ];
    }
}
