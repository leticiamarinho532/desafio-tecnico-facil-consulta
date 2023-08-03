<?php

namespace App\Repositories\Interfaces;

interface DoctorPatientRepositoryInterface
{
    /**
     *
     */
    public function createDoctorPatientLink(int $doctorId, int $patientId): mixed;
}
