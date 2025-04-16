<?php

use App\Http\Controllers\Api\Tests\Questions\QuestionsController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PanelController;

use App\Http\Controllers\Users\UsersController;

use App\Http\Controllers\Items\ItemsController;
use App\Http\Controllers\Categories\CategoriesController;

Route::get('/', function () {
    if (auth()->check()) {
        if(auth()->user()->role == 'Trabajador')
        {
            return redirect()->route('test.users.index');
        }
        return redirect()->route('panel');
    }
    return view('login');
})->name('/');

Route::group([], function () {
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('panel', [PanelController::class, 'index'])->name('panel');
    
    Route::get('showChangePassword', [UsersController::class, 'showChangePassword'])->name('users.showChangePassword');
    Route::post('updatePassword', [UsersController::class, 'updatePassword'])->name('users.updatePassword');

    Route::prefix('users')->middleware('CheckRoles:users')->group(function () {
        Route::get('index', [UsersController::class, 'index'])->name('users.index');
        Route::get('show/{user}', [UsersController::class, 'show'])->name('users.show');
        Route::post('store', [UsersController::class, 'store'])->name('users.store');
        Route::put('update/{user}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('delete/{user}', [UsersController::class, 'delete'])->name('users.delete');
        Route::delete('deleteModule/{userModule}/{user}', [UsersController::class, 'deleteModule'])->name('users.deleteModule');
        Route::post('addModules/{user}', [UsersController::class, 'addModules'])->name('users.addModules');
    });
    Route::prefix('items')->middleware('CheckRoles:items')->group(function () {
        Route::get('index', [ItemsController::class, 'index'])->name('items.index');
        Route::get('show/{item}', [ItemsController::class, 'show'])->name('items.show');
        Route::post('store', [ItemsController::class, 'store'])->name('items.store');
        Route::put('update/{item}', [ItemsController::class, 'update'])->name('items.update');
        Route::delete('delete/{item}', [ItemsController::class, 'delete'])->name('items.delete');
    });

    Route::prefix('categories')->middleware('CheckRoles:categories')->group(function () {
        Route::get('index', [CategoriesController::class, 'index'])->name('categories.index');
        Route::post('store', [CategoriesController::class, 'store'])->name('categories.store');
        Route::put('update/{category}', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('delete/{category}', [CategoriesController::class, 'delete'])->name('categories.delete');
        Route::get('show/{category}', [CategoriesController::class, 'show'])->name('categories.show');
    });
});
