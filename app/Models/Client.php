<?php

namespace App\Models;

use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

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
}
