<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', function () {
        return view('home');
    });

    Route::resource('/category', CategoryController::class);
    Route::get('/category/{id}/DeleteConfirmation', [CategoryController::class, 'deleteConfirmation'])->name('category.deleteConfirmation');

    Route::resource('/item', ItemController::class);
    Route::get('/item/{id}/DeleteConfirmation', [ItemController::class, 'deleteConfirmation'])->name('item.deleteConfirmation');
    Route::get('/item/autocomplete', [ItemController::class, 'autoCompleteItem'])->name('item.autocomplete');

    Route::resource('/supplier', SupplierController::class);
    Route::get('/supplier/{id}/DeleteConfirmation', [SupplierController::class, 'deleteConfirmation'])->name('supplier.deleteConfirmation');
    Route::get('/supplier/autocomplete', [SupplierController::class, 'autoCompleteSupplier'])->name('supplier.autocomplete');
    
    Route::resource('/unit', UnitController::class);
    Route::get('/unit/{id}/DeleteConfirmation', [UnitController::class, 'deleteConfirmation'])->name('unit.deleteConfirmation');

    Route::resource('/user', UserController::class);
    Route::get('/user/{id}/DeleteConfirmation', [UserController::class, 'deleteConfirmation'])->name('user.deleteConfirmation');

    Route::resource('/role', RoleController::class);
    Route::get('/role/{id}/DeleteConfirmation', [RoleController::class, 'deleteConfirmation'])->name('role.deleteConfirmation');

    Route::resource('/purchase', PurchaseController::class);
    Route::post('/purchase/detail', [PurchaseController::class, 'storePurchaseDetail'])->name('purchase.detail.store');
    Route::get('/purchase/{id}/DeleteConfirmation', [PurchaseController::class, 'deleteConfirmation'])->name('purchase.deleteConfirmation');
    Route::get('/purchase/create//item/autocomplete', [ItemController::class, 'autoCompleteItem'])->name('purchase.item.autocomplete');
    Route::get('/purchase/create/supplier/autocomplete', [SupplierController::class, 'autoCompleteSupplier'])->name('purchase.supplier.autocomplete');
});

require __DIR__ . '/auth.php';
