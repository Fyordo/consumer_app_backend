<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientFlat extends BaseModel
{
    use HasFactory;

    protected $table = 'client_flat';

    protected $fillable = [
        'client_id',
        'flat_id',
        'client_flat_status_id'
    ];

    protected $appends = [
        'client',
        'flat',
        'client_flat_status'
    ];

    public function client(){
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function getClientAttribute(){
        return $this->client()->first();
    }

    public function flat(){
        return $this->hasOne(Flat::class, 'id', 'flat_id');
    }

    public function getFlatAttribute(){
        return $this->flat()->first();
    }

    public function client_flat_status(){
        return $this->hasOne(ClientFlatStatus::class, 'id', 'client_flat_status_id');
    }

    public function getClientFlatStatusAttribute(){
        return $this->client_flat_status()->first();
    }
}
