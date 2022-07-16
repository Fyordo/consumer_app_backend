<?php

namespace App\Models;

use App\Http\Resources\FlatResource;
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
        'status',
        'features'
    ];

    public function status(){
        return $this->hasOne(FlatStatus::class, 'id', 'status_id');
    }

    public function getStatusAttribute(){
        return $this->status()->first();
    }

    public function features(){
        return $this->hasManyThrough(
            Feature::class, FeatureFlat::class,
            'flat_id',
            'id',
            'id',
            'feature_id'
        );
    }

    public function getFeaturesAttribute(){
        return $this->features()->get();
    }

    // Custom filter

    public function scopeFilter(Builder $query, array $filter = []){
        /**
         * @var $key string
         */
        foreach ($filter as $key => $value) {
            if ($key == "sort_name" || $key == "sort_order"){
                continue;
            }
            if (str_ends_with($key, "_from")){
                $field = substr($key, 0, strlen($key) - 5);
                $query
                    ->where($field, '>=', $value);
            }
            else if (str_ends_with($key, "_to")){
                $field = substr($key, 0, strlen($key) - 3);
                $query
                    ->where($field, '<=', $value);
            }
        }
    }
}
