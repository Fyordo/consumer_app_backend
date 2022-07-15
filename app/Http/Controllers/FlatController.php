<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlatRequest;
use App\Http\Resources\FlatResource;
use App\Models\Flat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FlatController extends Controller
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
            return FlatResource::collection(Flat::filter($filter)->order($filter)->get())
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
     * @param  FlatRequest  $request
     * @return FlatResource|JsonResponse
     */
    public function store(FlatRequest $request)
    {
        try {
            $validated = $request->validated();
            if (!$validated) {
                return response()->json(['error' => $validated], 403);
            }

            $flatModel = Flat::create([
                'title' => $request->title,
                'status_id' => $request->status_id,
                'full_space' => $request->full_space,
                'floor_count' => $request->floor_count,
                'living_space' => $request->living_space,
                'room_count' => $request->room_count,
                'balconyless_space' => $request->balconyless_space,
            ]);

            return (new FlatResource($flatModel))->additional($this->metaData(request()));
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
     * @return FlatResource|JsonResponse
     */
    public function show($flat)
    {
        try {
            $flatModel = Flat::where('id', '=', $flat)->first();
            if ($flatModel) {
                return (new FlatResource($flatModel))->additional($this->metaData(request()));
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
     * @param  FlatRequest  $request
     * @param  int  $flat
     * @return FlatResource|JsonResponse
     */
    public function update(FlatRequest $request, $flat)
    {
        try {
            $validated = $request->validated();
            if (!$validated) {
                return response()->json(['error' => $validated], 403);
            }

            $flatModel = Flat::where('id', '=', $flat)->first();
            if ($flatModel) {
                $flatModel->update([
                    'title' => $request->title,
                    'status_id' => $request->status_id,
                    'full_space' => $request->full_space,
                    'floor_count' => $request->floor_count,
                    'living_space' => $request->living_space,
                    'room_count' => $request->room_count,
                    'balconyless_space' => $request->balconyless_space,
                ]);
                return (new FlatResource($flatModel))->additional($this->metaData(request()));
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
            $flatModel = Flat::where('id', '=', $flat)->first();
            if ($flatModel) {
                $flatModel->delete();
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
