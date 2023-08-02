<?php

namespace App\Repositories\Interfaces;

interface DoctorRepositoryInterface
{
    /**
     *
     */
    public function getAll(): mixed;

    /**
     *
     */
    public function getAllByCity(int $cityId): mixed;

    /**
     *
     */
    public function createDoctor(array|object $doctorInfos): mixed;

    /**
     *
     */
    public function linkPatientToDoctor(int $doctorId, int $patientId): mixed;
}
