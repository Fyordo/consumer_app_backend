<?php

namespace App\Services;

use App\Http\Resources\ClientFlatResource;
use App\Http\Resources\FlatResource;
use App\Http\Resources\RecommendationResource;
use App\Models\Client;
use App\Models\ClientFlat;
use App\Models\Feature;
use App\Models\FeatureFlat;
use App\Models\Flat;
use Illuminate\Http\Request;

class ClientManagerService
{
    public function getFlats(Client $client){
        $client_flats = array_column(ClientFlat::where('client_id', '=', $client->id)->select('flat_id')->get()->toArray(), 'flat_id');

        return Flat::whereIn('id', $client_flats)->get();
    }

    public function getRequestRecommendations(Client $client){
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

        return Flat::filter($filter)->get();
    }

    public function getFlatRecommendation(Client $client, Request $request){
        $values = [];
        $bestFeatureFlat = [];

        foreach (Feature::all() as $feature){
            $values[$feature->id] = $request->input($feature->id);
            $bestFeatureFlat[$feature->id] = FeatureFlat::where('feature_id', '=', $feature->id)->orderBy('value', 'desc')->first();
        }

        $max_value = 0;
        $bestFlat = null;

        foreach ($bestFeatureFlat as $item) {
            $new_value = $item->value * $values[$item->feature_id];

            if ($new_value > $max_value){
                $max_value = $new_value;
                $bestFlat = $item->flat;
            }
        }

        return $bestFlat;
    }
}
