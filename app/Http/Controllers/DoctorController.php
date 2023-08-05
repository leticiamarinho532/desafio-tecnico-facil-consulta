<?php

namespace App\Http\Controllers;

use App\Repositories\DoctorPatientRepository;
use App\Repositories\DoctorRepository;
use App\Services\DoctorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct(
        private DoctorRepository $doctorRepository,
        private DoctorPatientRepository $doctorPatientRepository
    )
    {
    }

    public function index(): JsonResponse
    {
        $doctor = new DoctorService($this->doctorRepository, $this->doctorPatientRepository);

        $result = $doctor->getAll();

        if (is_array($result) && in_array('error', $result)) {
            return response()->json([
                'message' => $result['message']
            ], $result['code']);
        }

        return response()->json($result, 200);
    }

    public function show(int $cityId): JsonResponse
    {
        $doctor = new DoctorService($this->doctorRepository, $this->doctorPatientRepository);

        $result = $doctor->getAllByCity($cityId);

        if (is_array($result) && in_array('error', $result)) {
            return response()->json([
                'message' => $result['message']
            ], $result['code']);
        }

        return response()->json($result, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $doctor = new DoctorService($this->doctorRepository, $this->doctorPatientRepository);

        $result = $doctor->storeDoctor($input);

        if (is_array($result) && in_array('error', $result)) {
            return response()->json([
                'message' => $result['message']
            ], $result['code']);
        }

        return response()->json($result, 201);
    }

    public function createDoctorPatientLink(Request $request): JsonResponse
    {
        $input = $request->all();

        $doctor = new DoctorService($this->doctorRepository, $this->doctorPatientRepository);

        $result = $doctor->createDoctorPatientLink($input);

        if (is_array($result) && in_array('error', $result)) {
            return response()->json([
                'message' => $result['message']
            ], $result['code']);
        }

        return response()->json($result, 200);
    }
}
