<?php

namespace App\Http\Controllers;

use App\Repositories\DoctorPatientRepository;
use App\Repositories\DoctorRepository;
use App\Services\DoctorService;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct(
        private DoctorRepository $doctorRepository,
        private DoctorPatientRepository $doctorPatientRepository
    )
    {
    }

    public function index() 
    {
        $doctor = new DoctorService($this->doctorRepository, $this->doctorPatientRepository);

        $result = $doctor->getAll();

        if (!$result) {
            return response()->json([
                'message' => 'Não foi possivel exibir resultados.'
            ], 406);
        }

        return response()->json($result, 200);
    }

    public function show(int $cityId)
    {
        $doctor = new DoctorService($this->doctorRepository, $this->doctorPatientRepository);

        $result = $doctor->getAllByCity($cityId);

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

        $doctor = new DoctorService($this->doctorRepository, $this->doctorPatientRepository);

        $result = $doctor->storeDoctor($input);

        if (!$result) {
            return response()->json([
                'message' => 'Não foi possivel salvar um médico.'
            ], 406);
        }

        return response()->json($result, 200);
    }

    public function createDoctorPatientLink(Request $request)
    {
        $doctor = new DoctorService($this->doctorRepository, $this->doctorPatientRepository);

        $result = $doctor->createDoctorPatientLink($request->input('medico_id'), $request->input('paciente_id'));

        if (!$result) {
            return response()->json([
                'message' => 'Não foi vincular um paciente a um médico.'
            ], 406);
        }

        return response()->json($result, 200);
    }
}
