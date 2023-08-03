<?php

namespace App\Services;

use App\Repositories\Interfaces\PatientRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class PatientService
{
    public function __construct(
        private PatientRepositoryInterface $patientRepository,
    ) {
    }

    public function getAllDoctorPatients(int $doctorId): bool|object
    {
        try { 
            $result = $this->patientRepository->getAllDoctorPatients($doctorId);

            return $result;
        } catch (Exception $e) {
            Log::error('Error ao listar todos os pacientes: ' . $e->getMessage(), ['feature' => 'paciente']);

            return false;
        }
    }

    public function createPatient(array|object $patientInfos): bool|object
    {
        try { 
            $result = $this->patientRepository->createPatient($patientInfos);

            return $result;
        } catch (Exception $e) {
            Log::error('Error ao salvar um paciente: ' . $e->getMessage(), ['feature' => 'paciente']);

            return false;
        }
    }

    public function updatePatient(int $patientId, array|object $patientInfos): bool|object
    {
        try {
            $result = $this->patientRepository->updatePatient($patientId, $patientInfos);

            return $result;
        } catch (Exception $e) {
            Log::error('Error ao atualizar um paciente: ' . $e->getMessage(), ['feature' => 'paciente']);

            return false;
        }
    }
}
