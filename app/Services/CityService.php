<?php

namespace App\Services;

use App\Repositories\Interfaces\CityRepositoryInterface;

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
        } catch (\Throwable $th) {
            // return $th;
        }
    }
}
