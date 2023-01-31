<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\FilmMapTagController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//GET
Route::get('/', function () {
    return view('welcome');
});
Route::get('/api/films', [FilmMapTagController::class, 'index']);
Route::get('/api/tags', [TagController::class, 'index']);

//POST
Route::post('/api/films', [FilmController::class, 'store']);
Route::post('/api/tags', [TagController::class, 'store']);

//PUT
Route::put('/api/films/{id}', [FilmController::class, 'update']);
Route::put('/api/tags/{id}', [TagController::class, 'update']);

//DELETE
Route::delete('/api/films/{id}', [FilmController::class, 'destroy']);
Route::delete('/api/tags/{id}', [TagController::class, 'destroy']);