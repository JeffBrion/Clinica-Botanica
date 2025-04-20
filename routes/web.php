<?php

use App\Http\Controllers\Api\Tests\Questions\QuestionsController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PanelController;

use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Items\ItemsController;
use App\Http\Controllers\Categories\CategoriesController;
use App\Http\Controllers\Suppliers\SuppliersController;
use App\Http\Controllers\Inventories\InventoriesController;

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

    Route::prefix('suppliers')->middleware('CheckRoles:suppliers')->group(function () {
        Route::get('index', [SuppliersController::class, 'index'])->name('suppliers.index');
        Route::get('show/{supplier}', [SuppliersController::class, 'show'])->name('suppliers.show');
        Route::get('showitems/{supplier}', [SuppliersController::class, 'showitems'])->name('suppliers.showitems');
        Route::post('store', [SuppliersController::class, 'store'])->name('suppliers.store');
        Route::put('update/{supplier}', [SuppliersController::class, 'update'])->name('suppliers.update');
        Route::delete('delete/{supplier}', [SuppliersController::class, 'delete'])->name('suppliers.delete');
        Route::post('assignItem', [SuppliersController::class, 'assignItem'])->name('suppliers.assignItem');
        Route::delete('deleteItem/{item}', [SuppliersController::class, 'deleteItem'])->name('suppliers.deleteItem');
    });

    Route::prefix('inventories')->middleware('CheckRoles:inventories')->group(function () {
        Route::get('index', [InventoriesController::class, 'index'])->name('inventories.index');
        Route::get('entries', [InventoriesController::class, 'entries'])->name('inventories.entries');
        Route::get('entries/item/{supplier}', [InventoriesController::class, 'entriesItems'])->name('inventory.entriesItems');
        Route::get('show/{inventory}', [InventoriesController::class, 'show'])->name('inventories.show');
        Route::post('store', [InventoriesController::class, 'store'])->name('inventories.store');
        Route::put('update/{inventory}', [InventoriesController::class, 'update'])->name('inventories.update');
        Route::delete('delete/{inventory}', [InventoriesController::class, 'delete'])->name('inventories.delete');
    });

});
