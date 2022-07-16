<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * User
 *
 * @OA\Schema(
 *      schema="User",
 *      type="object",
 *      @OA\Property(
 *          property="id",
 *          description="Идентификатор пользователя",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="email",
 *          description="Почта пользователя",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="Когда пользователь был зарегистрирован",
 *          type="datetime"
 *      )
 *  )
 *
 * @package App\Models\User
 */

class UserResource extends JsonResource
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
            'email' => $this->email,
            'created_at' => $this->created_at,
        ];
    }
}
