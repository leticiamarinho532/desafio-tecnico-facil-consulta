<?php

namespace App\Repositories;

use App\Models\Patient;

use App\Repositories\Interfaces\PatientRepositoryInterface;

class PatientRepository implements PatientRepositoryInterface
{
    public function getAllDoctorPatients(int $doctorId): mixed
    {
        $pacientsId = Patient::select('paciente.id')
            ->join('medico_paciente', 'medico_paciente.paciente_id', '=', 'paciente.id')
            ->where('medico_paciente.medico_id', '=', $doctorId)
            ->get();

        $result = Patient::find($pacientsId);

        return $result;
    }

    public function createPatient(array|object $patientInfos): mixed
    {
        return Patient::firstOrCreate($patientInfos);
    }

    public function updatePatient(int $patientId, array|object $patientInfos): mixed
    {
        Patient::where('id', '=', $patientId)
            ->update($patientInfos);

        return Patient::find($patientId);
    }
}
