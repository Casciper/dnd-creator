<?php

use App\Http\Controllers\AjaxController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/get-race', [AjaxController::class, 'getRaceData']);
Route::post('/add-character', [AjaxController::class, 'addCharacter']);
Route::post('/get-characters' , [AjaxController::class, 'getCharacters']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
