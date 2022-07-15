<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientFlatStatus extends BaseModel
{
    use HasFactory;

    protected $table = 'client_flat_status';

    protected $fillable = [
        'title'
    ];
}
