<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Flat extends BaseModel
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
        'residential_complex_id',
        'cost',
        'is_ready',
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
