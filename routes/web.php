<?php

use App\Http\Controllers\SubAccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemReceiveController;
use App\Http\Controllers\PurchasePaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalePaymentController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Models\ItemReceive;
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
    Route::prefix('profile')->controller(ProfileController::class)
        ->group(function () {
            Route::get('/', 'edit')->name('profile.edit');
            Route::patch('/', 'update')->name('profile.update');
            Route::delete('/', 'destroy')->name('profile.destroy');
        });
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('/', function () {
    //     return view('home');
    // });

    Route::get('/', [HomeController::class, 'index']);

    Route::resource('/account', SubAccountController::class);
    Route::prefix('account')->controller(SubAccountController::class)
        ->group(function () {
            Route::get('/{id}/DeleteConfirmation', 'deleteConfirmation')
                ->name('account.deleteConfirmation');
        });

    Route::resource('/category', CategoryController::class);
    Route::prefix('category')->controller(CategoryController::class)
        ->group(function () {
            Route::get('/{id}/DeleteConfirmation', 'deleteConfirmation')
                ->name('category.deleteConfirmation');
        });

    Route::resource('/item', ItemController::class);
    Route::prefix('item')->controller(ItemController::class)
        ->group(function () {
            Route::get('/{id}/DeleteConfirmation', 'deleteConfirmation')
                ->name('item.deleteConfirmation');
            Route::post('/import', 'import')->name('items.import');
        });

    Route::resource('/purchase', PurchaseController::class);
    Route::prefix('purchase')->controller(PurchaseController::class)
        ->group(function () {
            Route::get('/{id}/print-pdf', 'print_invoice')->name('purchase.invoice');
            Route::post('/detail', 'storePurchaseDetail')
                ->name('purchase.detail.store');
            Route::get('/{id}/delete-confirmation',  'deleteConfirmation')
                ->name('purchase.deleteConfirmation');
            Route::get('/create/auto-complete-supplier', 'autoCompleteSupplier')->name('purchase.supplier.autoComplete');
            Route::get('/create/auto-complete-item', 'autoCompleteItem')->name('purchase.item.autoComplete');

            // To create and store item receive for purchase
            Route::resource('/item-receive', ItemReceiveController::class);
            Route::prefix('/item-receive')->controller(ItemReceiveController::class)->group(function () {
                Route::get('/delete-confirmation/{id}', 'deleteConfirmation')->name('item-receive.deleteConfirmation');
                Route::get('/{id}/create', 'create')->name('item-receive.createWithID');
            });

            // To create and store payment for purchase
            Route::resource('/purchase-payment', PurchasePaymentController::class);
            Route::prefix('/purchase-payment')->controller(PurchasePaymentController::class)->group(function () {
                Route::get('/delete-confirmation/{id}', 'deleteConfirmation')->name('purchase-payment.deleteConfirmation');
            });
        });


    Route::resource('/role', RoleController::class);
    Route::prefix('role')->controller(RoleController::class)
        ->group(function () {
            Route::get('/{id}/DeleteConfirmation', 'deleteConfirmation')
                ->name('role.deleteConfirmation');
        });

    Route::resource('/sale', SaleController::class);
    Route::prefix('sale')->controller(SaleController::class)
        ->group(function () {
            Route::get('/{id}/print-pdf', 'print_invoice')->name('sale.invoice');
            Route::post('/detail', 'storePurchaseDetail')
                ->name('sale.detail.store');
            Route::get('/{id}/delete-confirmation',  'deleteConfirmation')
                ->name('sale.deleteConfirmation');
            Route::get('/create/auto-complete-customer', 'autoCompleteCustomer')->name('sale.customer.autoComplete');
            Route::get('/create/auto-complete-item', 'autoCompleteItem')->name('sale.item.autoComplete');

            // To create and store payment for purchase
            Route::resource('/sale-payment', SalePaymentController::class);
            Route::prefix('/sale-payment')->controller(SalePaymentController::class)->group(function () {
                Route::get('/delete-confirmation/{id}', 'deleteConfirmation')->name('sale-payment.deleteConfirmation');
            });
        });

    Route::resource('/supplier', SupplierController::class);
    Route::prefix('supplier')->controller(SupplierController::class)
        ->group(function () {
            Route::get('/{id}/DeleteConfirmation', 'deleteConfirmation')
                ->name('supplier.deleteConfirmation');
        });

    Route::resource('/transaction', TransactionController::class);
    Route::prefix('transaction')->controller(TransactionController::class)
        ->group(function () {
            Route::get('/{id}/DeleteConfirmation', 'deleteConfirmation')
                ->name('transaction.deleteConfirmation');
        });

    Route::resource('/unit', UnitController::class);
    Route::prefix('unit')->controller(UnitController::class)
        ->group(function () {
            Route::get('/{id}/DeleteConfirmation', 'deleteConfirmation')
                ->name('unit.deleteConfirmation');
        });

    Route::resource('/user', UserController::class);
    Route::prefix('user')->controller(UserController::class)
        ->group(function () {
            Route::get('/{id}/DeleteConfirmation', 'deleteConfirmation')
                ->name('user.deleteConfirmation');
        });

    Route::resource('/store', StoreController::class);
    Route::prefix('store')->controller(StoreController::class)
        ->group(function () {
            Route::get('/{id}/DeleteConfirmation',  'deleteConfirmation')
                ->name('store.deleteConfirmation');
        });
});

require __DIR__ . '/auth.php';
