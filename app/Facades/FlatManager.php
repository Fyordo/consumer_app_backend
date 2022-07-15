<?php

namespace App\Facades;

use App\Models\Client;
use App\Models\Flat;
use Illuminate\Support\Facades\Facade;

/**
 * Менеджер зарплат
 *
 * @see \App\Services\FlatManagerService
 * @method static getGraph(Flat $flat)
 */

class FlatManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return self::class;
    }
}
