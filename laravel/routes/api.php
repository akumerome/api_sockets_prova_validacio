<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\SnippetController;
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

//Public routes

/*Route::get('all', [SnippetController::class, "index"]);
Route::post('add', [SnippetController::class, "store"]);
Route::get('get/{id}', [SnippetController::class, "show"]);
Route::patch('update/{id}', [TodosController::class, 'update']); //alternativamente con put
Route::delete('destroy/{id}', [TodosController::class, 'destroy']);*/

Route::post('register', [UserController::class, "register"]); //http://127.0.0.1:8000/api/register
Route::post('login', [UserController::class, "login"]); //http://127.0.0.1:8000/api/login

//Protected routes

Route::group( ['middleware' => ["auth:sanctum"]], function(){
    Route::get('user-profile', [UserController::class, "userProfile"]); //http://127.0.0.1:8000/api/user-profile
    Route::get('logout', [UserController::class, "logout"]); //http://127.0.0.1:8000/api/logout

    Route::get('all', [SnippetController::class, "index"]); //http://127.0.0.1:8000/api/all
    Route::post('add', [SnippetController::class, "store"]); //http://127.0.0.1:8000/api/add
    Route::get('get/{id}', [SnippetController::class, "show"]); //http://127.0.0.1:8000/api/get/xx
    Route::patch('update/{id}', [SnippetController::class, 'update']); //alternativamente con put //http://127.0.0.1:8000/api/update/xx
    Route::delete('destroy/{id}', [SnippetController::class, 'destroy']); //http://127.0.0.1:8000/api/destroy/xx
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
