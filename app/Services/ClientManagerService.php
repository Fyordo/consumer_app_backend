<?php

namespace App\Services;

use App\Http\Resources\ClientFlatResource;
use App\Http\Resources\FlatResource;
use App\Http\Resources\RecommendationResource;
use App\Models\Client;
use App\Models\ClientFlat;
use App\Models\Flat;

class ClientManagerService
{
    public function getFlats(Client $client){
        $client_flats = ClientFlatResource::collection(
            ClientFlat::where('client_id', '=', $client->id
            )->get()
        );
        return $client_flats;
    }

    public function getRecommendations(Client $client){
        $recommendations = RecommendationResource::collection($client->recommendations()->get());

        $filter = [];

        foreach ($recommendations as $item) {
            $request_body = (array)json_decode($item['request_body']);
            foreach ($request_body as $field => $value) {
                if ($field == "sort_name" || $field == "sort_order"){
                    continue;
                }
                if (isset($filter[$field])){
                    $filter[$field] = ((float)$filter[$field] + (float)$value) / 2.0;
                }
                else{
                    $filter[$field] = $value;
                }
            }
        }

        return FlatResource::collection(Flat::filter($filter)->get());
    }
}
