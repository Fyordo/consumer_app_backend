<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Flat
 *
 * @OA\Schema(
 *      schema="Flat",
 *      type="object",
 *      @OA\Property(
 *          property="id",
 *          description="Идентификатор квартиры",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="title",
 *          description="Название квартиры",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="status",
 *          description="Статус квартиры",
 *          type="object",
 *          ref="#/components/schemas/FlatStatus"
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
 *      ),
 *      @OA\Property(
 *          property="features",
 *          description="Готова ли квартира",
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/Feature")
 *      )
 *  )
 *
 * @package App\Models\Flat
 */

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
            'status' => $this->when($this->status, new FlatStatusResource($this->status)),
            'full_space' => $this->full_space,
            'floor_count' => $this->floor_count,
            'living_space' => $this->living_space,
            'room_count' => $this->room_count,
            'balconyless_space' => $this->balconyless_space,
            'residential_complex_id' => $this->residential_complex_id,
            'address' => $this->address,
            'cost' => $this->cost,
            'square_cost' => $this->square_cost,
            'is_ready' => (bool)$this->is_ready,
            'repair' => $this->repair,
            'view' => $this->view,
            'material' => $this->material,
            'height' => $this->height,
            'parking' => $this->parking,
            'features' => $this->when($this->features, FeatureResource::collection($this->features)),
        ];
    }
}
