<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'cidades'
], function ($router) {
    Route::get('/', 'CityController@index');
});
