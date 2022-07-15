<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    public function scopeFilter(Builder $query, array $filter = []){
        foreach ($filter as $key => $value) {
            if ($key == "sort_name" || $key == "sort_order"){
                continue;
            }
            $query->orWhereIn($key, is_array($value) ? $value : [$value]);
        }
    }

    public function scopeOrder(Builder $query, array $filter = []){
        $sort_name = $filter["sort_name"] ?? "id";
        $sort_order = $filter["sort_order"] ?? "asc";

        $query->orderBy($sort_name, $sort_order);
    }
}
