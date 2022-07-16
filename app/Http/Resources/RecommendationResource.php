<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Recommendation
 *
 * @OA\Schema(
 *      schema="Recommendation",
 *      type="object",
 *      @OA\Property(
 *          property="id",
 *          description="Идентификатор рекомендации",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="client",
 *          description="Клиент",
 *          type="object",
 *          ref="#/components/schemas/User"
 *      ),
 *      @OA\Property(
 *          property="request_body",
 *          description="Тело запроса пользователя",
 *          type="string",
 *          format="json"
 *      )
 *  )
 *
 * @package App\Models\Recommendation
 */

class RecommendationResource extends JsonResource
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
            'request_body' => json_decode($this->request_body),
            'client' => $this->when($this->client, new ClientResource($this->client)),
        ];
    }
}
