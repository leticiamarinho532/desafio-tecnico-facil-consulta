<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Repositories\Interfaces\DoctorRepositoryInterface;

class DoctorRepository implements DoctorRepositoryInterface
{
    public function getAll(): mixed
    {
        return Doctor::all();
    }

    public function getAllByCity(int $cityId): mixed
    {
        return Doctor::where('cidade_id', '=', $cityId)->get();
    }

    public function createDoctor(array|object $doctorInfos): mixed
    {
        return Doctor::firstOrCreate($doctorInfos);
    }
}
