<?php

use Illuminate\Support\Facades\Route;

// Autentição
Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

// Rotas que necessitam de autenticação
Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers'
], function ($router) {
    Route::group([
        'prefix' => 'medicos'
    ], function ($router) {
        Route::post('/', 'DoctorController@store');
        Route::post('/{id_medico}/pacientes', 'DoctorController@createDoctorPatientLink');
    });
});

// Demais Rotas
Route::group([
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'cidades'
], function ($router) {
    Route::get('/', 'CityController@index');
    Route::get('/{id_cidade}/medicos', 'DoctorController@show');
});

Route::group([
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'medicos'
], function ($router) {
    Route::get('/', 'DoctorController@index');
});
