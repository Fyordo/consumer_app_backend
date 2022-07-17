<?php

namespace App\Http\Controllers;

use App\Facades\ClientManager;
use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Http\Resources\FlatResource;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nette\NotImplementedException;

/**
 * @OA\Get(
 *     path="/api/client",
 *     description="Получение списка клиентов",
 *     tags={"Client"},
 *     @OA\Response(
 *          response="200",
 *          description="Список клиентов найден",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="array",
 *                          description="Массив найденных клиентов",
 *                          @OA\Items(ref="#/components/schemas/Client")
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
 *     path="/api/client/{client}",
 *     description="Получение клиента",
 *     tags={"Client"},
 *     @OA\Parameter(
 *          name="client",
 *          description="Идентификатор клиента",
 *          in="path",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
 *     @OA\Response(
 *          response="200",
 *          description="Клиент найден",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="object",
 *                          description="Клиент",
 *                          ref="#/components/schemas/Client"
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
 *     path="/api/client",
 *     description="Добавить клиента",
 *     tags={"Client"},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                  ref="#/components/schemas/ClientRequest"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="Клиент добавлен",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="object",
 *                          description="Добавленный клиент",
 *                          ref="#/components/schemas/Client"
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
 *     path="/api/client/{client}",
 *     description="Отредактировать клиента",
 *     tags={"Client"},
 *     @OA\Parameter(
 *          name="client",
 *          description="Идентификатор клиента",
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
 *                  ref="#/components/schemas/ClientRequest"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="Клиент отредактирован",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="object",
 *                          description="Отредактированный клиент",
 *                          ref="#/components/schemas/Client"
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
 *     path="/api/client/{client}",
 *     description="Удалить клиента",
 *     tags={"Client"},
 *     @OA\Parameter(
 *          name="client",
 *          description="Идентификатор клиента",
 *          in="path",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
 *     @OA\Response(
 *          response="200",
 *          description="Клиент удалён",
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
 *     path="/api/client/flats",
 *     description="Получение списка квартир клиента",
 *     tags={"Client"},
 *     @OA\Response(
 *          response="200",
 *          description="Список квартир клиента найден",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="array",
 *                          description="Массив найденных квартир клиента",
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
 * @OA\Get(
 *     path="/api/client/recommendations",
 *     description="Получение рекомендованных квартир клиента",
 *     tags={"Client"},
 *     @OA\Response(
 *          response="200",
 *          description="Список рекомендованных квартир клиента найден",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="array",
 *                          description="Массив рекомендованных квартир клиента",
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
 * @OA\Get(
 *     path="/api/client/flat/recommendation",
 *     description="Получение рекомендованной квартиры для клиента",
 *     tags={"Client"},
 *     @OA\Response(
 *          response="200",
 *          description="Рекомендованная квартира клиента найдена",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="array",
 *                          description="Рекомендованная квартира клиента",
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
 * @OA\Get(
 *     path="/api/client/flat/recommendation/ai",
 *     description="Получение рекомендованных квартир для клиента (с использованием ИИ)",
 *     tags={"Client"},
 *     @OA\Response(
 *          response="200",
 *          description="Рекомендованные квартиры клиента найдена",
 *          @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                      type="object",
 *                      @OA\Property(
 *                          property="data",
 *                          type="array",
 *                          description="Рекомендованные квартиры для клиента",
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
 */

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

    public function getMyFlats(){
        return FlatResource::collection(ClientManager::getFlats(Auth::user()->client))->additional($this->metaData(request()));
    }

    public function getRequestRecommendations(){
        return FlatResource::collection(ClientManager::getRequestRecommendations(Auth::user()->client))->additional($this->metaData(request()));
    }

    public function getFlatRecommendation(){
        return (new FlatResource(ClientManager::getFlatRecommendation(Auth::user()->client, request()->all())))->additional($this->metaData(request()));
    }

    public function getAIRecommendations(){
        return FlatResource::collection(ClientManager::getAIRecommendations(Auth::user()->client))->additional($this->metaData(request()));
    }
}
