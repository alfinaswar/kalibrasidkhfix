<?php

use App\Http\Controllers\AlatUkurController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstrumenController;
use App\Http\Controllers\MasterAlatController;
use App\Http\Controllers\MasterCustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SerahTerimaAlatController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider and all of them will
 * | be assigned to the "web" middleware group. Make something great!
 * |
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::prefix('master-alat')->group(function () {
        Route::GET('/', [MasterAlatController::class, 'index'])->name('alat.index');
        Route::GET('/create', [MasterAlatController::class, 'create'])->name('alat.create');
        Route::POST('/simpan', [MasterAlatController::class, 'store'])->name('alat.store');
        Route::GET('/edit/{id}', [MasterAlatController::class, 'edit'])->name('alat.edit');
        Route::PUT('/update/{id}', [MasterAlatController::class, 'update'])->name('alat.update');
        Route::delete('hapus/{id}', [MasterAlatController::class, 'destroy'])->name('alat.destroy');
    });
    Route::prefix('master-instrumen')->group(function () {
        Route::GET('/', [InstrumenController::class, 'index'])->name('instrumen.index');
        Route::GET('/create', [InstrumenController::class, 'create'])->name('instrumen.create');
        Route::POST('/simpan', [InstrumenController::class, 'store'])->name('instrumen.store');
        Route::GET('/edit/{id}', [InstrumenController::class, 'edit'])->name('instrumen.edit');
        Route::PUT('/update/{id}', [InstrumenController::class, 'update'])->name('instrumen.update');
        Route::delete('hapus/{id}', [InstrumenController::class, 'destroy'])->name('instrumen.destroy');
    });
    Route::prefix('master-customer')->group(function () {
        Route::GET('/', [MasterCustomerController::class, 'index'])->name('customer.index');
        Route::GET('/create', [MasterCustomerController::class, 'create'])->name('customer.create');
        Route::POST('/simpan', [MasterCustomerController::class, 'store'])->name('customer.store');
        Route::GET('/edit/{id}', [MasterCustomerController::class, 'edit'])->name('customer.edit');
        Route::PUT('/update/{id}', [MasterCustomerController::class, 'update'])->name('customer.update');
        Route::delete('hapus/{id}', [MasterCustomerController::class, 'destroy'])->name('customer.destroy');
    });
    Route::prefix('serah-terima')->group(function () {
        Route::GET('/', [SerahTerimaAlatController::class, 'index'])->name('st.index');
        Route::GET('/create', [SerahTerimaAlatController::class, 'create'])->name('st.create');
        Route::POST('/simpan', [SerahTerimaAlatController::class, 'store'])->name('st.store');
        Route::GET('/edit/{id}', [SerahTerimaAlatController::class, 'edit'])->name('st.edit');
        Route::PUT('/update/{id}', [SerahTerimaAlatController::class, 'update'])->name('st.update');
        Route::delete('hapus/{id}', [SerahTerimaAlatController::class, 'destroy'])->name('st.destroy');
    });
});
