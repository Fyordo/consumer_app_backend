<?php

namespace App\Http\Resources;

use App\Models\Flat;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * ResidentialComplex
 *
 * @OA\Schema(
 *      schema="ResidentialComplex",
 *      type="object",
 *      @OA\Property(
 *          property="id",
 *          description="Идентификатор ЖК",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="title",
 *          description="Название ЖК",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="address",
 *          description="Адрес ЖК",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="flats",
 *          description="Квартиры ЖК",
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/Flat")
 *      )
 *  )
 *
 * @package App\Models\ResidentialComplex
 */

class ResidentialComplexResource extends JsonResource
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
            'address' => $this->address,
            'min_cost' => $this->when($this->flats, Flat::where('flats.residential_complex_id', '=', $this->id)->orderBy('cost', 'asc')->first()->cost),
            'updated_at' => strtotime($this->updated_at),
            'flats' => []//$this->when($this->flats, FlatResource::collection($this->flats))
        ];
    }
}
