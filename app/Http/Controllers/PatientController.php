<?php

namespace App\Http\Controllers;

use App\Repositories\PatientRepository;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(
        private PatientRepository $patientRepository,
    )
    {
    }

    public function show(int $doctorId)
    {
        $patient = new PatientService($this->patientRepository);

        $result = $patient->getAllDoctorPatients($doctorId);

        if (!$result) {
            return response()->json([
                'message' => 'Não foi possivel exibir resultados.'
            ], 406);
        }

        return response()->json($result, 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $patient = new PatientService($this->patientRepository);

        $result = $patient->createPatient($input);

        if (!$result) {
            return response()->json([
                'message' => 'Não foi possivel salvar um paciente.'
            ], 406);
        }

        return response()->json($result, 200);
    }

    public function update(int $patientId, Request $request)
    {
        $input = $request->all();

        $patient = new PatientService($this->patientRepository);

        $result = $patient->updatePatient($patientId, $input);

        if (!$result) {
            return response()->json([
                'message' => 'Não foi possivel atualizar um paciente.'
            ], 406);
        }

        return response()->json($result, 200);
    }
}
