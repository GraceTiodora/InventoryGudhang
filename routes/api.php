<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InventoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API Routes untuk Inventory
Route::prefix('inventories')->group(function () {
    // CRUD Resource Routes
    Route::get('/', [InventoryController::class, 'index'])->name('inventories.index');
    Route::post('/', [InventoryController::class, 'store'])->name('inventories.store');
    Route::get('/{id}', [InventoryController::class, 'show'])->name('inventories.show');
    Route::put('/{id}', [InventoryController::class, 'update'])->name('inventories.update');
    Route::patch('/{id}', [InventoryController::class, 'update']);
    Route::delete('/{id}', [InventoryController::class, 'destroy'])->name('inventories.destroy');

    // Additional Routes
    Route::get('/search/query', [InventoryController::class, 'search'])->name('inventories.search');
    Route::post('/{id}/adjust-stock', [InventoryController::class, 'adjustStock'])->name('inventories.adjust-stock');
    Route::get('/category/{category}', [InventoryController::class, 'getByCategory'])->name('inventories.by-category');
    Route::get('/report/low-stock', [InventoryController::class, 'getLowStock'])->name('inventories.low-stock');
    Route::get('/report/out-of-stock', [InventoryController::class, 'getOutOfStock'])->name('inventories.out-of-stock');
});
