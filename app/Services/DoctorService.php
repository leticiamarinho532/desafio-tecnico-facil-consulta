<?php

namespace App\Services;

use App\Repositories\Interfaces\DoctorPatientRepositoryInterface;
use App\Repositories\Interfaces\DoctorRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class DoctorService
{
    public function __construct(
        private DoctorRepositoryInterface $doctorRepository,
        private DoctorPatientRepositoryInterface $doctorPatientRepository
    ) {
    }

    public function getAll(): bool|object
    {
        try {
            $result = $this->doctorRepository->getAll();

            return $result;
        } catch (Exception $e) {
            Log::error('Error ao listar todos os medicos: ' . $e->getMessage(), ['feature' => 'medico']);

            return false;
        }
    }

    public function getAllByCity(int $cityId): bool|object
    {
        try {
            $result = $this->doctorRepository->getAllByCity($cityId);

            return $result;
        } catch (Exception $e) {
            Log::error('Error ao listar todos os medicos de uma cidade: ' . $e->getMessage(), ['feature' => 'medico']);

            return false;
        }
    }

    public function storeDoctor(array|object $doctorInfos): bool|object
    {
        try {
            $result = $this->doctorRepository->createDoctor($doctorInfos);

            return $result;

        } catch (Exception $e) {
            Log::error('Error ao salvar um medico: ' . $e->getMessage(), ['feature' => 'medico']);

            return false;
        }
    }

    public function createDoctorPatientLink(int $doctorId, int $patientId): bool|array
    {
        try {
            $result = $this->doctorPatientRepository->createDoctorPatientLink($doctorId, $patientId);

            return $result;
        } catch (Exception $e) {
            Log::error('Error ao vincular um paciente ao médico' . $e->getMessage(), ['feature' => 'medico']);

            return false;
        }
    }
}
