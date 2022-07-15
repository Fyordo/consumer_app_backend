<?php

namespace App\Services;

use App\Http\Resources\ClientFlatResource;
use App\Http\Resources\FlatResource;
use App\Models\Client;
use App\Models\ClientFlat;
use App\Models\Flat;

class FlatManagerService
{
    public function getGraph(Flat $flat) : array{
        $result = [
            '-1' => $flat->cost / 1.04, // Цены с 2021 года повысились на 4%
            '0' => $flat->cost,
            '1' => $flat->cost * 1.15, // Эксперты предсказывают рост на 15%
        ];

        $xValues = [-1, 0, 1];
        $yValues = [$flat->cost / 1.04, $flat->cost, $flat->cost * 1.15];

        for ($x = 2; $x < 11; $x++){
            $size = count($result);

            $lagrangePol = 0.0;

            for ($i = 0; $i < $size; $i++){
                $basicPol = 1.0;
                for ($j = 0; $j < $size; $j++){
                    if ($i !== $j){
                        $basicPol *= ($x - $xValues[$j])/($xValues[$i] - $xValues[$j]);
                    }
                }

                $lagrangePol += $basicPol * $yValues[$i];
            }

            $result[$x] = $lagrangePol;
            $xValues[] = $x;
            $yValues[] = $lagrangePol;
        }

        return $result;
    }
}
