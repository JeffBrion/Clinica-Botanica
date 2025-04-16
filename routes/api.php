<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Instances\IntancesController;
use App\Http\Controllers\Api\Users\UsersController;
use App\Http\Controllers\Api\Tests\TestController;
use App\Http\Controllers\Api\Tests\Questions\QuestionsController;
use App\Http\Controllers\Api\Evaluations\EvaluationsPeriodController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([], function () {
    Route::prefix('instances')->group(function() {
        Route::get('search/{text}', [IntancesController::class, 'search'])->name('api.instances.search');
    });

    Route::prefix('users')->group(function() {
        Route::get('search/{text}', [UsersController::class, 'search'])->name('api.users.search');
    });

    Route::prefix('tests')->group(function() {
        Route::get('search/{text}', [TestController::class, 'search'])->name('api.tests.search');
    });

    Route::prefix('questions')->group(function(){
        Route::get('{test_id}/search/{text}', [QuestionsController::class, 'search'])->name('api.questions.search');
    });

    Route::prefix('evaluation/period')->group(function(){
        Route::get('search/{text}', [EvaluationsPeriodController::class, 'search'])->name('api.evaluation.period.search');
    });
});
