<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientFlatRequest;
use App\Http\Resources\ClientFlatResource;
use App\Models\ClientFlat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientFlatController extends Controller
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
            return ClientFlatResource::collection(ClientFlat::where($filter)->get())
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
     * @param  ClientFlatRequest  $request
     * @return ClientFlatResource|JsonResponse
     */
    public function store(ClientFlatRequest $request)
    {
        try {
            $validated = $request->validated();
            if (!$validated) {
                return response()->json(['error' => $validated], 403);
            }

            $clientFlatModel = ClientFlat::create([
                'client_id' => $request->client_id,
                'flat_id' => $request->flat_id,
                'client_flat_status_id' => $request->client_flat_status_id
            ]);

            return (new ClientFlatResource($clientFlatModel))->additional($this->metaData(request()));
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
     * @param  int  $flat
     * @return ClientFlatResource|JsonResponse
     */
    public function show($flat)
    {
        try {
            $clientFlatModel = ClientFlat::where('id', '=', $flat)->first();
            if ($clientFlatModel) {
                return (new ClientFlatResource($clientFlatModel))->additional($this->metaData(request()));
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
     * @param  ClientFlatRequest  $request
     * @param  int  $flat
     * @return ClientFlatResource|JsonResponse
     */
    public function update(ClientFlatRequest $request, $flat)
    {
        try {
            $validated = $request->validated();
            if (!$validated) {
                return response()->json(['error' => $validated], 403);
            }

            $clientFlatModel = ClientFlat::where('id', '=', $flat)->first();
            if ($clientFlatModel) {
                $clientFlatModel->update([
                    'client_id' => $request->client_id,
                    'flat_id' => $request->flat_id,
                    'client_flat_status_id' => $request->client_flat_status_id
                ]);
                return (new ClientFlatResource($clientFlatModel))->additional($this->metaData(request()));
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
     * @param  int  $flat
     * @return JsonResponse
     */
    public function destroy($flat)
    {
        try {
            $clientFlatModel = ClientFlat::where('id', '=', $flat)->first();
            if ($clientFlatModel) {
                $clientFlatModel->delete();
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
