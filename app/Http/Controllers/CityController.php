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

        if (is_array($result) && in_array('error', $result)) {
            return response()->json([
                'message' => $result['message']
            ], $result['code']);
        }

        return response()->json($result, 200);
    }
}
