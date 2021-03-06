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
        'view',
        'repair',
        'material',
        'height',
        'parking',
    ];

    protected $appends = [
        'status',
        'features',
        'square_cost',
        'address'
    ];

    public function status(){
        return $this->hasOne(FlatStatus::class, 'id', 'status_id');
    }

    public function getStatusAttribute(){
        return $this->status()->first();
    }

    public function getSquareCostAttribute(){
        return $this->cost / $this->full_space;
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

    public function getAddressAttribute(){
        return ResidentialComplex::where('id', '=', $this->residential_complex_id)->first()->address;
    }

    // Custom filter

    public function scopeFilter(Builder $query, array $filter = []){
        /**
         * @var $key string
         */
        foreach ($filter as $key => $value) {
            if ($key == "sort_name" ||
                $key == "sort_order"){
                continue;
            }
            if ($key == "is_ready" ||
                $key == "repair" ||
                $key == "view" ||
                $key == "room_count" ||
                $key == "parking" ||
                $key == "material"
            ){
                $query->whereIn($key, is_array($value) ? $value : [$value]);
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

    public static function getBaseFilter(){
        return [
            'status_id' => 0,
            'full_space_from' => 0.0,
            'full_space_to' => 0.0,
            'floor_count_from' => 0.0,
            'floor_count_to' => 0.0,
            'living_space_from' => 0.0,
            'living_space_to' => 0.0,
            'balconyless_space_from' => 0.0,
            'balconyless_space_to' => 0.0,
            'cost_from' => 0,
            'cost_to' => 0,
            'height_from' => 0.0,
            'height_to' => 0.0,
        ];
    }
}
