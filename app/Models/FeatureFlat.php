<?php

namespace App\Models;

use App\Http\Resources\FeatureResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureFlat extends Model
{
    use HasFactory;
    protected $table = 'feature_flat';

    protected $fillable = [
        'flat_id',
        'feature_id'
    ];

    protected $appends = [
        'flat',
        'feature'
    ];

    public function flat(){
        return $this->hasOne(Flat::class, 'id', 'flat_id');
    }

    public function getFlatAttribute(){
        return $this->flat()->first();
    }

    public function feature(){
        return $this->hasOne(Feature::class, 'id', 'feature_id');
    }

    public function getFeatureAttribute(){
        return $this->feature()->first();
    }
}
