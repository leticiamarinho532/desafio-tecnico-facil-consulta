<?php

namespace App\Services;

use App\Repositories\Interfaces\DoctorPatientRepositoryInterface;
use App\Repositories\Interfaces\DoctorRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Validation\ValidationException;

class DoctorService
{
    public function __construct(
        private DoctorRepositoryInterface $doctorRepository,
        private DoctorPatientRepositoryInterface $doctorPatientRepository
    ) {
    }

    public function getAll(): array|object
    {
        try {
            $result = $this->doctorRepository->getAll();

            return $result;
        } catch (Exception $e) {
            Log::error('Error ao listar todos os médicos: ' . $e->getMessage(), ['feature' => 'medico']);

            return ['error' => true, 'message' => 'Não foi possivel listar os médicos.', 'code' => 406];
        }
    }

    public function getAllByCity(int $cityId): array|object
    {
        try {
            $result = $this->doctorRepository->getAllByCity($cityId);

            return $result;
        } catch (Exception $e) {
            Log::error('Error ao listar todos os médicos de uma cidade: ' . $e->getMessage(), ['feature' => 'medico']);

            return ['error' => true, 'message' => 'Não foi possivel listar os médicos de uma cidade.', 'code' => 406];
        }
    }

    public function storeDoctor(array|object $doctorInfos): array|object
    {
        try {
            $this->validateStoreDoctorParams($doctorInfos);

            $result = $this->doctorRepository->createDoctor($doctorInfos);

            return $result;
        } catch (ValidationException $e) {
            Log::error('Error ao salvar os dados de um médico: ' . $e->getMessage(), ['feature' => 'medico']);

            return ['error' => true, 'message' => $e->errors(), 'code' => 422];
        } catch (Exception $e) {
            Log::error('Error ao salvar os dados de um médico: ' . $e->getMessage(), ['feature' => 'medico']);

            return ['error' => true, 'message' => 'Não foi possivel salvar os dados de um médico.', 'code' => 406];
        }
    }

    public function createDoctorPatientLink(array|object $linkInfos): array|object
    {
        try {
            $this->validateCreateLinkDoctorPatientLinkParams($linkInfos);

            $result = $this->doctorPatientRepository->createDoctorPatientLink($linkInfos['medico_id'], $linkInfos['paciente_id']);

            return $result;
        } catch (ValidationException $e) {
            Log::error('Error ao vincular um paciente ao médico: ' . $e->getMessage(), ['feature' => 'medico']);

            return ['error' => true, 'message' => $e->errors(), 'code' => 422];
        } catch (Exception $e) {
            Log::error('Error ao vincular um paciente ao médico: ' . $e->getMessage(), ['feature' => 'medico']);

            return ['error' => true, 'message' => 'Não foi possivel vincular um paciente ao médico.', 'code' => 406];
        }
    }

    private function validateStoreDoctorParams(array|object $params): null|Exception
    {
        $validator = Validator::make(
            $params,
            [
                'nome' => 'required|string|max:100',
                'especialidade' => 'string|max:100',
                'cidade_id' => 'required|integer',
            ],
            [
                'required' => ':attribute deve ser declarado no body',
                'string' => ':attribute deve ser tipo :type',
                'integer' => ':attribute deve ser tipo :type',
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator, $validator->messages());
        }

        return null;
    }

    private function validateCreateLinkDoctorPatientLinkParams(array|object $params): null|Exception
    {
        $validator = Validator::make(
            $params,
            [
                'medico_id' => 'required|integer',
                'paciente_id' => 'required|integer',
            ],
            [
                'required' => ':attribute deve ser declarado no body',
                'integer' => ':attribute deve ser tipo :type',
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator, $validator->messages());
        }

        return null;
    }
}
