<?php

namespace App\Services;

use App\Repositories\Interfaces\CityRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class CityService
{
    public function __construct(
        private CityRepositoryInterface $cityRepository
    ) {
    }

    public function getAll(): mixed
    {
        try {
            $result = $this->cityRepository->getAll();

            return $result;
        } catch (Exception $e) {
            Log::error('Error ao listar todas as cidades: ' . $e->getMessage(), ['feature' => 'cidades']);

            return false;
        }
    }
}
