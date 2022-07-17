<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $table = 'recommendations';

    protected $fillable = [
        'request_body',
        'client_id'
    ];

    protected $appends = [
        'client'
    ];

    public function client(){
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function getClientAttribute(){
        return $this->client()->first();
    }

    public function getRequestAttribute(){
        return json_decode($this->request_body);
    }
}
