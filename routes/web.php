<?php

use App\Http\Controllers\AlatUkurController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstrumenController;
use App\Http\Controllers\InventoriController;
use App\Http\Controllers\KajiUlangController;
use App\Http\Controllers\MasterAlatController;
use App\Http\Controllers\MasterCustomerController;
use App\Http\Controllers\MasterMetodeController;
use App\Http\Controllers\PoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProsesKalibrasiController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SerahTerimaAlatController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\SuratPerintahKerjaController;
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
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    //USER
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    Route::prefix('master-inventori')->group(function () {
        Route::GET('/', [InventoriController::class, 'index'])->name('inv.index');
        Route::GET('/create', [InventoriController::class, 'create'])->name('inv.create');
        Route::GET('/create-kategori', [InventoriController::class, 'KategoriInventori'])->name('inv.create-kategori');
        Route::POST('/simpan', [InventoriController::class, 'store'])->name('inv.store');
        Route::POST('/simpan-kategori', [InventoriController::class, 'storeKategori'])->name('inv.store-kategori');
        Route::GET('/edit/{id}', [InventoriController::class, 'edit'])->name('inv.edit');
        Route::GET('/edit-kategori/{id}', [InventoriController::class, 'editKategori'])->name('inv.edit-kategori');
        Route::PUT('/update/{id}', [InventoriController::class, 'update'])->name('inv.update');
        Route::PUT('/update-kategori/{id}', [InventoriController::class, 'updateKategori'])->name('inv.update-kategori');
        Route::delete('hapus/{id}', [InventoriController::class, 'destroy'])->name('inv.destroy');
        Route::delete('hapus-kategori/{id}', [InventoriController::class, 'destroyKategori'])->name('inv.destroy-kategori');
    });
    Route::prefix('master-instrumen')->group(function () {
        Route::GET('/', [InstrumenController::class, 'index'])->name('instrumen.index');
        Route::GET('/create', [InstrumenController::class, 'create'])->name('instrumen.create');
        Route::POST('/simpan', [InstrumenController::class, 'store'])->name('instrumen.store');
        Route::GET('/edit/{id}', [InstrumenController::class, 'edit'])->name('instrumen.edit');
        Route::PUT('/update/{id}', [InstrumenController::class, 'update'])->name('instrumen.update');
        Route::delete('hapus/{id}', [InstrumenController::class, 'destroy'])->name('instrumen.destroy');
        Route::get('/getHarga/{id}', [InstrumenController::class, 'getHarga'])->name('instrument.getHarga');
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
        Route::GET('/detail/{id}', [SerahTerimaAlatController::class, 'detail'])->name('st.detail');
        Route::POST('/update-data/{id}', [SerahTerimaAlatController::class, 'update'])->name('st.update');
        Route::delete('hapus/{id}', [SerahTerimaAlatController::class, 'destroy'])->name('st.destroy');
        Route::GET('/pdf/{id}', [SerahTerimaAlatController::class, 'GeneratePdf'])->name('st.pdf');
        Route::GET('/cetak-stiker/{id}', [SerahTerimaAlatController::class, 'CetakStiker'])->name('st.cetak-stiker');
    });
    Route::prefix('kaji-ulang')->group(function () {
        Route::GET('/', [KajiUlangController::class, 'index'])->name('ku.index');
        Route::GET('/create', [KajiUlangController::class, 'create'])->name('ku.create');
        Route::GET('/form-kaji-ulang/{id}', [KajiUlangController::class, 'formKaji'])->name('ku.form-kaji-ulang');
        Route::POST('/simpan', [KajiUlangController::class, 'store'])->name('ku.store');
        Route::GET('/edit/{id}', [KajiUlangController::class, 'edit'])->name('ku.edit');
        Route::GET('/detail/{id}', [KajiUlangController::class, 'show'])->name('ku.cetak');
        Route::GET('/cetak-kup/{id}', [KajiUlangController::class, 'cetakKup'])->name('ku.cetak-kup');
        Route::PUT('/update/{id}', [KajiUlangController::class, 'update'])->name('ku.update');
        Route::delete('hapus/{id}', [KajiUlangController::class, 'destroy'])->name('ku.destroy');
    });
    Route::prefix('master-metode')->group(function () {
        Route::GET('/', [MasterMetodeController::class, 'index'])->name('metode.index');
        Route::delete('hapus/{id}', [MasterMetodeController::class, 'destroy'])->name('metode.destroy');
        Route::GET('/edit/{id}', [MasterMetodeController::class, 'edit'])->name('metode.edit');
        Route::POST('/simpan', [MasterMetodeController::class, 'store'])->name('metode.store');
        Route::PUT('/update/{id}', [MasterMetodeController::class, 'update'])->name('metode.update');
    });
    Route::prefix('quotation')->group(function () {
        Route::GET('/', [QuotationController::class, 'index'])->name('quotation.index');
        Route::GET('/buat/{id}', [QuotationController::class, 'create'])->name('quotation.form-quotation');
        Route::POST('/simpan', [QuotationController::class, 'store'])->name('quotation.store');
        Route::GET('/edit/{id}', [QuotationController::class, 'edit'])->name('quotation.edit');
        Route::POST('/update/{id}', [QuotationController::class, 'update'])->name('quotation.update');
        Route::delete('hapus/{id}', [QuotationController::class, 'destroy'])->name('quotation.destroy');
        Route::GET('/cetak-pdf/{id}', [QuotationController::class, 'GeneratePdf'])->name('quotation.pdf');
    });
    Route::prefix('po')->group(function () {
        Route::GET('/', [PoController::class, 'index'])->name('po.index');
        Route::GET('/buat/{id}', [PoController::class, 'create'])->name('po.form-po');
        Route::POST('/simpan', [PoController::class, 'store'])->name('po.store');
        Route::GET('/edit/{id}', [PoController::class, 'edit'])->name('po.edit');
        Route::POST('/update/{id}', [PoController::class, 'update'])->name('po.update');
        Route::delete('hapus/{id}', [PoController::class, 'destroy'])->name('po.destroy');
        Route::GET('/cetak-pdf/{id}', [PoController::class, 'GeneratePdf'])->name('po.pdf');
    });
    Route::prefix('surat-tugas')->group(function () {
        Route::GET('/', [SuratPerintahKerjaController::class, 'index'])->name('spk.index');
        Route::GET('/surat-tugas/po/{id}', [SuratPerintahKerjaController::class, 'create'])->name('spk.form-spk');
        Route::GET('/surat-tugas/', [SuratPerintahKerjaController::class, 'create'])->name('spk.form');
        Route::POST('/simpan', [SuratPerintahKerjaController::class, 'store'])->name('spk.store');
        Route::GET('/edit/{id}', [SuratPerintahKerjaController::class, 'edit'])->name('spk.edit');
        Route::PUT('/update/{id}', [SuratPerintahKerjaController::class, 'update'])->name('spk.update');
        Route::delete('hapus/{id}', [SuratPerintahKerjaController::class, 'destroy'])->name('spk.destroy');
        Route::GET('/cetak-pdf/{id}', [SuratPerintahKerjaController::class, 'GeneratePdf'])->name('ku.pdf');
    });
    Route::prefix('job-order')->group(function () {
        Route::GET('/', [SertifikatController::class, 'index'])->name('job.index');
        Route::GET('/kalibrasi/{id}', [SertifikatController::class, 'create'])->name('job.kalibrasi');
        Route::GET('/hasil-pdf/{id}', [SertifikatController::class, 'HasilPdf'])->name('job.hasilpdf');
        Route::GET('/hasil-excel/{id}', [SertifikatController::class, 'HasilExcel'])->name('job.hasilexcel');
        // Route::GET('/surat-tugas/', [SuratPerintahKerjaController::class, 'create'])->name('spk.form');
        Route::POST('/simpan', [SertifikatController::class, 'store'])->name('job.store');

        // Route::GET('/edit/{id}', [SuratPerintahKerjaController::class, 'edit'])->name('spk.edit');
        // Route::PUT('/update/{id}', [SuratPerintahKerjaController::class, 'update'])->name('spk.update');
        // Route::delete('hapus/{id}', [SuratPerintahKerjaController::class, 'destroy'])->name('spk.destroy');
        // Route::GET('/cetak-pdf/{id}', [SuratPerintahKerjaController::class, 'GeneratePdf'])->name('ku.pdf');
    });
});
