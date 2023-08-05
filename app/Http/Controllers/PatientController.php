<?php

namespace App\Http\Controllers;

use App\Repositories\PatientRepository;
use App\Services\PatientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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

        if (is_array($result) && in_array('error', $result)) {
            return response()->json([
                'message' => $result['message']
            ], $result['code']);
        }

        return response()->json($result, 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $patient = new PatientService($this->patientRepository);

        $result = $patient->createPatient($input);

        if (is_array($result) && in_array('error', $result)) {
            return response()->json([
                'message' => $result['message']
            ], $result['code']);
        }

        return response()->json($result, 201);
    }

    public function update(int $patientId, Request $request)
    {
        $input = $request->all();

        $patient = new PatientService($this->patientRepository);

        $result = $patient->updatePatient($patientId, $input);

        if (is_array($result) && in_array('error', $result)) {
            return response()->json([
                'message' => $result['message']
            ], $result['code']);
        }

        return response()->json($result, 200);
    }
}
