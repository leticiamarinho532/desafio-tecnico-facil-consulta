<?php

namespace App\Repositories;

use App\Repositories\Interfaces\DoctorPatientRepositoryInterface;
use App\Models\DoctorPatient;

class DoctorPatientRepository implements DoctorPatientRepositoryInterface
{
    public function createDoctorPatientLink(int $doctorId, int $patientId): mixed
    {
        $getOrCreateLink = DoctorPatient::firstOrCreate([
            'medico_id' => $doctorId,
            'paciente_id' => $patientId
        ]);

        $result = [
            'medico' => $getOrCreateLink->doctor,
            'paciente' => []
        ];

        return $result ;
    }
}
