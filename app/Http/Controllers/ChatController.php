<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Resources\UserResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        try {
            $user = Auth::user();
            if (
                $request->input('message') === null || // Сообщение не написано
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
