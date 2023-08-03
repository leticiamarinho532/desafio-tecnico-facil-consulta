<?php

namespace App\Repositories\Interfaces;

interface PatientRepositoryInterface
{
    public function getAllDoctorPatients(int $doctorId): mixed;

    public function updatePatient(int $patientId, array|object $patientInfos): mixed;

    public function createPatient(array|object $patientInfos): mixed;
}
