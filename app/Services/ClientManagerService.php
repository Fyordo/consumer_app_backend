<?php

namespace App\Services;

use App\Http\Resources\ClientFlatResource;
use App\Http\Resources\FlatResource;
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

    public function getRecomendations(){
        // TODO Рекомендации для клиента
    }
}
