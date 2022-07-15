<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentialComplex extends BaseModel
{
    use HasFactory;

    protected $table = 'residential_complexes';

    protected $fillable = [
        'title',
        'address'
    ];

    protected $appends = [
        'flats'
    ];

    public function flats(){
        return $this->hasMany(Flat::class, 'residential_complex_id', 'id');
    }

    public function getFlatsAttribute(){
        return $this->flats()->get();
    }
}
