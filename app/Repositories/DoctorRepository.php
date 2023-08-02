<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Models\DoctorPatient;
use App\Repositories\Interfaces\DoctorRepositoryInterface;

class DoctorRepository implements DoctorRepositoryInterface
{
    public function getAll(): mixed
    {
        return Doctor::all();
    }

    public function getAllByCity(int $cityId): mixed
    {
        return Doctor::where('cidade_id', '=', $cityId);
    }

    public function createDoctor(array|object $doctorInfos): mixed
    {
        return Doctor::firstOrCreate($doctorInfos);
    }

    public function linkPatientToDoctor(int $doctorId, int $patientId): mixed
    {
        return DoctorPatient::firstOrCreate([
            'medico_id' => $doctorId, 
            'patient_id' => $patientId
        ])->doctor->patient;
    }
}
