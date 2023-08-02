<?php

namespace App\Http\Controllers;

use App\Repositories\CityRepository;
use App\Services\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(
        private CityRepository $cityRepository
    )
    {
    }

    public function index(): object
    {
        $cities = new CityService($this->cityRepository);

        $result = $cities->getAll();

        if (!$result) {
            return response()->json([
                'message' => 'Não foi possivel exibir resultados.'
            ], 406);
        }

        return response()->json($result, 200);
    }
}
