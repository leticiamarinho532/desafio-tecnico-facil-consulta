<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api', 'namespace' => 'App\Http\Controllers'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('user', 'AuthController@me');
});

Route::middleware('VerifyJwtMiddleware')->group(function () {
    Route::group(['prefix' => 'medicos', 'namespace' => 'App\Http\Controllers'], function () {
        Route::post('/', 'DoctorController@store');
        Route::post('/{id_medico}/pacientes', 'DoctorController@createDoctorPatientLink');
        Route::get('/{id_medico}/pacientes', 'PatientController@show');
    });

    Route::group(['prefix' => 'pacientes', 'namespace' => 'App\Http\Controllers'], function () {
        Route::post('/', 'PatientController@store');
        Route::put('/{id_paciente}', 'PatientController@update');
    });
});

Route::group(['namespace' => 'App\Http\Controllers', 'prefix' => 'cidades'], function () {
    Route::get('/', 'CityController@index');
    Route::get('/{id_cidade}/medicos', 'DoctorController@show');
});

Route::group(['namespace' => 'App\Http\Controllers', 'prefix' => 'medicos'], function () {
    Route::get('/', 'DoctorController@index');
});
