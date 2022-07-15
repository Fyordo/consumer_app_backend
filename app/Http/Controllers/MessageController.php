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
     * @return NotImplementedException
     */
    public function store(MessageRequest $request)
    {
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
                return response()->json([], 402);
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
