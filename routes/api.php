<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Carpeta;
use App\Models\Subcarpeta;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Carpetas
Route::get('carpetas', 'CarpetaController@index');
Route::get('carpetas/{carpeta}', 'CarpetaController@show');
Route::post('carpetas', 'CarpetaController@store');
Route::put('carpetas/{carpeta}', 'CarpetaController@update');
Route::delete('carpetas/{carpeta}', 'CarpetaController@delete');

//Subcarpetas
Route::get('subcarpetas', 'SubcarpetaController@index');
Route::get('subcarpetas/{subcarpeta}', 'SubcarpetaController@show');
Route::post('subcarpetas', 'SubcarpetaController@store');
Route::put('subcarpetas/{subcarpeta}', 'SubcarpetaController@update');
Route::delete('subcarpetas/{subcarpeta}', 'SubcarpetaController@delete');

