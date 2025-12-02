<?php

use App\Http\Controllers\api\SponteApiController;
use App\Http\Middleware\ApiTokenMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('api.token')->group(function () {

    Route::get('/alunos', [SponteApiController::class, 'getAlunos']);

    Route::get('/contas/pagar', [SponteApiController::class, 'getContasPagar']);

});
