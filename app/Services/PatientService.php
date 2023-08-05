<?php

namespace App\Services;

use App\Repositories\Interfaces\PatientRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Validation\ValidationException;

class PatientService
{
    public function __construct(
        private PatientRepositoryInterface $patientRepository,
    ) {
    }

    public function getAllDoctorPatients(int $doctorId): array|object
    {
        try { 
            $result = $this->patientRepository->getAllDoctorPatients($doctorId);

            return $result;
        } catch (Exception $e) {
            Log::error('Error ao listar todos os pacientes: ' . $e->getMessage(), ['feature' => 'paciente']);

            return ['error' => true, 'message' => 'Não foi possivel listar os pacientes.', 'code' => 406];
        }
    }

    public function createPatient(array|object $patientInfos): array|object
    {
        try {
            $this->validateParams($patientInfos);

            $result = $this->patientRepository->createPatient($patientInfos);

            return $result;
        } catch (ValidationException $e) {
            Log::error('Error ao salvar um paciente: ' . $e->getMessage(), ['feature' => 'paciente']);

            return ['error' => true, 'message' => $e->errors(), 'code' => 422];
        } catch (Exception $e) {
            Log::error('Error ao salvar um paciente: ' . $e->getMessage(), ['feature' => 'paciente']);

            return ['error' => true, 'message' => 'Não foi possivel salvar um paciente.', 'code' => 406];
        }
    }

    public function updatePatient(int $patientId, array|object $patientInfos): array|object
    {
        try {
            $this->validateParams($patientInfos);

            $formattedPatientInfos = $this->removeCpfFromUpdateInfos($patientInfos);
            $result = $this->patientRepository->updatePatient($patientId, $formattedPatientInfos);

            return $result;
        } catch (ValidationException $e) {
            Log::error('Error ao atualizar um paciente: ' . $e->getMessage(), ['feature' => 'paciente']);

            return ['error' => true, 'message' => $e->errors(), 'code' => 422];
        } catch (Exception $e) {
            Log::error('Error ao atualizar um paciente: ' . $e->getMessage(), ['feature' => 'paciente']);

            return ['error' => true, 'message' => 'Não foi possível atualizar um paciente.', 'code' => 406];
        }
    }

    private function removeCpfFromUpdateInfos(array|object $patientInfos): array|object
    {
        if ($patientInfos['cpf']) {
            unset($patientInfos['cpf']);

            return $patientInfos;
        }

        return $patientInfos;
    }

    private function validateParams(array|object $params): null|Exception
    {
        $validator = Validator::make(
            $params,
            [
                'nome' => 'required|string|max:100',
                'cpf' => 'string|max:20',
                'celular' => 'required|string|max:20',
            ],
            [
                'required' => ':attribute deve ser declarado no body',
                'string' => ':attribute deve ser tipo :type',

            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator, $validator->messages());
        }

        return null;
    }
}
