<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Message
 *
 * @OA\Schema(
 *      schema="Message",
 *      type="object",
 *      @OA\Property(
 *          property="id",
 *          description="Идентификатор сообщения",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="message",
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
 *          property="send_time",
 *          description="Время отправки",
 *          type="datetime"
 *      )
 *  )
 *
 * @package App\Models\Message
 */

class MessageResource extends JsonResource
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
            'message' => $this->message,
            'user' => $this->when($this->user, new UserResource($this->user)),
            'send_time' => $this->created_at
        ];
    }
}
