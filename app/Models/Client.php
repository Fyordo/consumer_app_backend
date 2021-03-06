<?php

namespace App\Models;

use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends BaseModel
{
    use HasFactory;

    protected $table = 'client';

    protected $fillable = [
        'name',
        'phone',
        'user_id',
    ];

    protected $appends = [
        'email',
        'user'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getUserAttribute(){
        return $this->user()->first();
    }

    public function getEmailAttribute(){
        return $this->user->email;
    }

    public function recommendations(){
        return $this->hasMany(Recommendation::class, 'client_id', 'id');
    }
}
