<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nette\NotImplementedException;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|JsonResponse
     */
    public function index()
    {
        $filter = request()->all();
        try {
            return ClientResource::collection(Client::where($filter)->get())
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
     * @param  ClientRequest  $request
     * @return ClientResource|JsonResponse
     */
    public function store(ClientRequest $request)
    {
        try {
            $validated = $request->validated();
            if (!$validated) {
                return response()->json(['error' => $validated], 403);
            }

            $user = User::create([
                'email' => $request->email,
                'password' => 'password'
            ]);

            $clientModel = Client::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'user_id' => $user->id,
            ]);

            return (new ClientResource($clientModel))->additional($this->metaData(request()));
        }
        catch (\Exception $ex){
            return response()->json([
                'error' => $ex->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $client
     * @return ClientResource|JsonResponse
     */
    public function show($client)
    {
        try {
            $clientModel = Client::where('id', '=', $client)->first();
            if ($clientModel) {
                return (new ClientResource($clientModel))->additional($this->metaData(request()));
            } else {
                return response()->json([
                    'error' => 'Object doesn\'t exist'
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
     * @param  ClientRequest  $request
     * @param  int  $client
     * @return ClientResource|JsonResponse
     */
    public function update(ClientRequest $request, $client)
    {
        try {
            $validated = $request->validated();
            if (!$validated) {
                return response()->json(['error' => $validated], 403);
            }

            $clientModel = Client::where('id', '=', $client)->first();
            if ($clientModel) {
                $clientModel->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                ]);
                $clientModel->user->update([
                    'email' => $request->email,
                ]);
                return (new ClientResource($clientModel))->additional($this->metaData(request()));
            } else {
                return response()->json([
                    'error' => 'Object doesn\'t exist'
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
     * @param  int  $client
     * @return JsonResponse
     */
    public function destroy($client)
    {
        try {
            $clientModel = Client::where('id', '=', $client)->first();
            if ($clientModel) {
                $clientModel->delete();
                return response()->json([], 400);
            } else {
                return response()->json([
                    'error' => 'Object doesn\'t exist'
                ], 403);
            }
        }
        catch (\Exception $ex){
            return response()->json([
                'error' => $ex->getMessage()
            ]);
        }
    }
}
