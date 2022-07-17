<?php

namespace App\Services;

use App\Http\Resources\ClientFlatResource;
use App\Http\Resources\FlatResource;
use App\Models\Client;
use App\Models\ClientFlat;
use App\Models\Flat;
use Phpml\Regression\LeastSquares;

class FlatManagerService
{
    public function getGraph(Flat $flat) : array{
        $samples = [[2021], [2022], [2023]];
        $targets = [$flat->cost / 1.04, $flat->cost, $flat->cost * 1.15];

        $regression = new LeastSquares();
        $regression->train($samples, $targets);

        $result = [
            '2021' => $flat->cost / 1.04, // Цены с 2021 года повысились на 4%
            '2022' => $flat->cost,
            '2023' => $flat->cost * 1.15, // Эксперты предсказывают рост на 15%
        ];

        for ($i = 2024; $i <= 2032; $i++){
            $result[(string)$i] = $regression->predict([$i]);
        }

        return $result;
    }
}
