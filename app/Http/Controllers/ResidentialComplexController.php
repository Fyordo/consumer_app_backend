<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResidentialComplexRequest;
use App\Http\Resources\ResidentialComplexResource;
use App\Models\ResidentialComplex;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResidentialComplexController extends Controller
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
            return ResidentialComplexResource::collection(ResidentialComplex::filter($filter)->order($filter)->get())
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
     * @param  ResidentialComplexRequest  $request
     * @return ResidentialComplexResource|JsonResponse
     */
    public function store(ResidentialComplexRequest $request)
    {
        try {
            $validated = $request->validated();
            if (!$validated) {
                return response()->json(['error' => $validated], 403);
            }

            $complexModel = ResidentialComplex::create([
                'title' => $request->title,
                'address' => $request->address
            ]);

            return (new ResidentialComplexResource($complexModel))->additional($this->metaData(request()));
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
     * @param  int  $complex
     * @return ResidentialComplexResource|JsonResponse
     */
    public function show($complex)
    {
        try {
            $complexModel = ResidentialComplex::where('id', '=', $complex)->first();
            if ($complexModel) {
                return (new ResidentialComplexResource($complexModel))->additional($this->metaData(request()));
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
     * @param  ResidentialComplexRequest  $request
     * @param  int  $complex
     * @return ResidentialComplexResource|JsonResponse
     */
    public function update(ResidentialComplexRequest $request, $complex)
    {
        try {
            $validated = $request->validated();
            if (!$validated) {
                return response()->json(['error' => $validated], 403);
            }

            $complexModel = ResidentialComplex::where('id', '=', $complex)->first();
            if ($complexModel) {
                $complexModel->update([
                    'title' => $request->title,
                    'address' => $request->address
                ]);
                return (new ResidentialComplexResource($complexModel))->additional($this->metaData(request()));
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
     * @param  int  $complex
     * @return JsonResponse
     */
    public function destroy($complex)
    {
        try {
            $complexModel = ResidentialComplex::where('id', '=', $complex)->first();
            if ($complexModel) {
                $complexModel->delete();
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
