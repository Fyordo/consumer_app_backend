<?php

namespace App\Facades;

use App\Models\Client;
use Illuminate\Support\Facades\Facade;

/**
 * Менеджер зарплат
 *
 * @see \App\Services\ClientManagerService
 * @method static getFlats(Client $client)
 */

class ClientManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return self::class;
    }
}
