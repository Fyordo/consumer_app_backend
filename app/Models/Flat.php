<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    use HasFactory;

    protected $table = 'flats';

    protected $fillable = [
        'title',
        'status_id',
        'full_space',
        'floor_count',
        'living_space',
        'room_count',
        'balconyless_space',
    ];

    protected $appends = [
        'status'
    ];

    public function status(){
        return $this->hasOne(FlatStatus::class, 'id', 'status_id');
    }

    public function getStatusAttribute(){
        return $this->status()->first();
    }
}
