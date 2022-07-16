<?php

namespace App\Http\Controllers;

use App\Facades\FlatManager;
use App\Http\Requests\FlatRequest;
use App\Http\Resources\FlatResource;
use App\Models\Flat;
use App\Models\Recommendation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Get(
 *     path="/api/flat",
 *     description="Получение списка квартир",
 *     tags={"Flat"},
 *     @OA\Response(
 *          response="200",
 *          description="Список квартир найден",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="array",
 *                          description="Массив найденных квартир",
 *                          @OA\Items(ref="#/components/schemas/Flat")
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
 *     path="/api/flat/{flat}",
 *     description="Получение квартиры",
 *     tags={"Flat"},
 *     @OA\Parameter(
 *          name="flat",
 *          description="Идентификатор квартиры",
 *          in="path",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
 *     @OA\Response(
 *          response="200",
 *          description="Квартира найдена",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="object",
 *                          description="Квартира",
 *                          ref="#/components/schemas/Flat"
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
 *     path="/api/flat",
 *     description="Добавить квартиру",
 *     tags={"Flat"},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                  ref="#/components/schemas/FlatRequest"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="Квартира добавлена",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="object",
 *                          description="Добавленная квартира",
 *                          ref="#/components/schemas/Flat"
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
 *     path="/api/flat/{flat}",
 *     description="Отредактировать квартиру",
 *     tags={"Flat"},
 *     @OA\Parameter(
 *          name="flat",
 *          description="Идентификатор квартиры",
 *          in="path",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                  ref="#/components/schemas/FlatRequest"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="Квартира отредактирована",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="object",
 *                          description="Отредактированная квартира",
 *                          ref="#/components/schemas/Flat"
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
 *     path="/api/flat/{flat}",
 *     description="Удалить квартиру",
 *     tags={"Flat"},
 *     @OA\Parameter(
 *          name="flat",
 *          description="Идентификатор квартиры",
 *          in="path",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
 *     @OA\Response(
 *          response="200",
 *          description="Квартира удалёна",
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
 * @OA\Get(
 *     path="/api/flat/graph/{flat}",
 *     description="Получение графика роста цены квартиры",
 *     tags={"Flat"},
 *     @OA\Parameter(
 *          name="flat",
 *          description="Идентификатор квартиры, график которой будет построен",
 *          in="path",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
 *     @OA\Response(
 *          response="200",
 *          description="График построен",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="array",
 *                          description="График",
 *                          @OA\Items(ref="object")
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
            Recommendation::create([
                'request_body' => json_encode($filter),
                'client_id' => Auth::user()->client->id
            ]);
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
                'residential_complex_id' => $request->residential_complex_id,
                'view' => $request->view,
                'repair' => $request->repair,
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
                Recommendation::create([
                    'request_body' => json_encode(['id' => $flat])
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
                    'residential_complex_id' => $request->residential_complex_id,
                    'cost' => $request->cost,
                    'is_ready' => $request->is_ready,
                    'view' => $request->view,
                    'repair' => $request->repair,
                    'height' => $request->height,
                    'material' => $request->material,
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

    public function graph($flat){
        try {
            $flat = Flat::where('id', '=', $flat)->first();
            if ($flat) {
                return FlatManager::getGraph($flat);
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
