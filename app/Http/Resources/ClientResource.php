<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Client
 *
 * @OA\Schema(
 *      schema="Client",
 *      type="object",
 *      @OA\Property(
 *          property="id",
 *          description="Идентификатор клиента",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          description="ФИО клиента",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="user",
 *          description="Пользователь",
 *          type="object",
 *          ref="#/components/schemas/User"
 *      ),
 *      @OA\Property(
 *          property="email",
 *          description="Почта клиента",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="phone",
 *          description="Телефон клиента",
 *          type="string"
 *      )
 *  )
 *
 * @package App\Models\Client
 */

class ClientResource extends JsonResource
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
            'name' => $this->name,
            'phone' => $this->phone,
            'user' => $this->when($this->user, new UserResource($this->user)),
            'email' => $this->when($this->user, $this->email),
        ];
    }
}
