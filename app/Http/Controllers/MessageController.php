<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\SendMessageRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Nette\NotImplementedException;

/**
 * @OA\Get(
 *     path="/api/message",
 *     description="Получение списка сообщений",
 *     tags={"Message"},
 *     @OA\Response(
 *          response="200",
 *          description="Список сообщений найден",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="array",
 *                          description="Массив найденных сообщений",
 *                          @OA\Items(ref="#/components/schemas/Message")
 *                      ),
 *                      @OA\Property(
 *                          property="meta",
 *                          description="Мета-теги",
 *                          type="object"
 *                      )
 *                  )
 *             }
 *         )
 *      )
 * )
 *
 * @OA\Get(
 *     path="/api/message/{message}",
 *     description="Получение сообщение",
 *     tags={"Message"},
 *     @OA\Response(
 *          response="200",
 *          description="Сообщение найдено",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="object",
 *                          description="Сообщение",
 *                          ref="#/components/schemas/Message"
 *                      ),
 *                      @OA\Property(
 *                          property="meta",
 *                          description="Мета-теги",
 *                          type="object"
 *                      )
 *                  )
 *             }
 *         )
 *      )
 * )
 *
 * @OA\Post(
 *     path="/api/message",
 *     description="Добавить сообщение",
 *     tags={"Message"},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                  ref="#/components/schemas/MessageRequest"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="Сообщение добавлено",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="object",
 *                          description="Добавленное сообщение",
 *                          ref="#/components/schemas/Message"
 *                      ),
 *                      @OA\Property(
 *                          property="meta",
 *                          description="Мета-теги",
 *                          type="object"
 *                      )
 *                  )
 *             }
 *         )
 *      )
 * )
 *
 * @OA\Put(
 *     path="/api/message/{message}",
 *     description="Отредактировать сообщение",
 *     tags={"Message"},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                  ref="#/components/schemas/MessageRequest"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="Сообщение отредактировано",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="object",
 *                          description="Отредактированное сообщение",
 *                          ref="#/components/schemas/Message"
 *                      ),
 *                      @OA\Property(
 *                          property="meta",
 *                          description="Мета-теги",
 *                          type="object"
 *                      )
 *                  )
 *             }
 *         )
 *      )
 * )
 *
 * @OA\Delete(
 *     path="/api/message/{message}",
 *     description="Получение списка сообщений",
 *     tags={"Message"},
 *     @OA\Response(
 *          response="200",
 *          description="Сообщение удалено",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="null",
 *                      ),
 *                      @OA\Property(
 *                          property="meta",
 *                          description="Мета-теги",
 *                          type="object"
 *                      )
 *                  )
 *             }
 *         )
 *      )
 * )
 */

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|JsonResponse
     */
    public function index()
    {
        try {
            return MessageResource::collection(Message::with('user')->where('user_id', '=', Auth::id())->get())
                ->additional($this->metaData(request()));
        }
        catch (\Exception $ex){
            return response()->json([
                'error' => $ex->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MessageRequest  $request
     * @return NotImplementedException|JsonResponse
     */
    public function store(MessageRequest $request)
    {
        $validated = $request->validated();
        if (!$validated) {
            return response()->json(['error' => $validated], 403);
        }


        return new NotImplementedException();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $message
     * @return MessageResource|JsonResponse
     */
    public function show($message)
    {
        try {
            $messageModel = Message::with('user')
                ->where('user_id', '=', Auth::id())
                ->where('id', '=', $message)->first();
            if ($messageModel) {
                return (new MessageResource($messageModel))->additional($this->metaData(request()));
            } else {
                return response()->json([
                    'error' => 'Permission denied'
                ], 403);
            }
        }
        catch (\Exception $ex){
            return response()->json([
                'error' => $ex->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MessageRequest  $request
     * @param  int  $message
     * @return MessageResource|JsonResponse
     */
    public function update(MessageRequest $request, $message)
    {
        try {
            $validated = $request->validated();
            if (!$validated) {
                return response()->json(['error' => $validated], 403);
            }

            $messageModel = Message::with('user')
                ->where('user_id', '=', Auth::id())
                ->where('id', '=', $message)->first();
            if ($messageModel) {
                $messageModel->update($request->all());
                return (new MessageResource($messageModel))->additional($this->metaData(request()));
            } else {
                return response()->json([
                    'error' => 'Permission denied'
                ], 403);
            }
        }
        catch (\Exception $ex){
            return response()->json([
                'error' => $ex->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $message
     * @return JsonResponse
     */
    public function destroy($message)
    {
        try {
            $messageModel = Message::with('user')
                ->where('user_id', '=', Auth::id())
                ->where('id', '=', $message)->first();
            if ($messageModel) {
                $messageModel->delete();
                return response()->json([], 400);
            } else {
                return response()->json([
                    'error' => 'Permission denied'
                ], 403);
            }
        }
        catch (\Exception $ex){
            return response()->json([
                'error' => $ex->getMessage()
            ]);
        }
    }

    public function send(SendMessageRequest $request){
        try {
            $user = Auth::user();
            if (
                $request->input('message') === '' // Сообщение пустое
            ){
                return [
                    'status' => 'Message wasn\'t sent!',
                    'error' => 'Empty message'
                ];
            }
            $message = $user->messages()->create([
                'message' => $request->input('message')
            ]);
            broadcast(new MessageSent((new UserResource($user)), $message))->toOthers();
            return ['status' => 'Message Sent!'];
        }
        catch (\Exception $ex){
            return [
                'status' => 'Message wasn\'t sent!',
                'error' => $ex->getMessage()
            ];
        }
    }
}
