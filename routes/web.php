<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\DaftarBarangKeluarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterKategoriController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\MasterRakController;
use App\Http\Controllers\MasukRakController;
use App\Http\Controllers\SewaBarangController;

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

Route::get('/', function () {
    return view('login');
});

Route::post('login', [AuthController::class,'login'])->name('login');
Route::get('logout', [AuthController::class,'logout'])->name('logout');
Route::get('reset-password/{id}', [AuthController::class,'resetPassword'])->name('reset-password');
Route::post('update-password', [AuthController::class,'updatePassword'])->name('update-password');

Route::group(['prefix'=>'dashboard','as'=>'dashboard.'], function(){
    Route::get('/', [DashboardController::class,'index'])->name('index');
    Route::get('chart-column', [DashboardController::class,'chartColumn'])->name('chartColumn');
    Route::get('chart-pie', [DashboardController::class,'chartPie'])->name('chartPie');
});

Route::middleware(['auth:admin'])->group(function () {
    // Profil
    Route::group(['prefix'=>'admin/profil','as'=>'admin.profil.'], function(){
        Route::get('/', [ProfilController::class,'index'])->name('index');
        Route::post('update', [ProfilController::class,'update'])->name('update');
    });

    // Master User
    Route::group(['prefix'=>'users','as'=>'users.'], function(){
        Route::get('/', [UsersController::class,'index'])->name('index');
        Route::post('store', [UsersController::class,'store'])->name('store');
        Route::post('update', [UsersController::class,'update'])->name('update');
        Route::get('delete/{id}', [UsersController::class,'delete'])->name('delete');
    });
    
    // Master Kategori
    Route::group(['prefix'=>'master-kategori','as'=>'master-kategori.'], function(){
        Route::get('/', [MasterKategoriController::class,'index'])->name('index');
        Route::post('store', [MasterKategoriController::class,'store'])->name('store');
        Route::post('update', [MasterKategoriController::class,'update'])->name('update');
        Route::get('delete/{id}', [MasterKategoriController::class,'delete'])->name('delete');
    });

    // Master Rak
    Route::group(['prefix'=>'master-rak','as'=>'master-rak.'], function(){
        Route::get('/', [MasterRakController::class,'index'])->name('index');
        Route::post('store', [MasterRakController::class,'store'])->name('store');
        Route::post('update', [MasterRakController::class,'update'])->name('update');
        Route::get('delete/{id}', [MasterRakController::class,'delete'])->name('delete');
    });
    
    // Daftar Barang Masuk
    Route::group(['prefix'=>'daftar-barang-masuk','as'=>'daftar-barang-masuk.'], function(){
        Route::get('/', [BarangController::class,'index'])->name('index');
        Route::post('store', [BarangController::class,'store'])->name('store');
        Route::post('update', [BarangController::class,'update'])->name('update');
        Route::get('delete/{id}', [BarangController::class,'delete'])->name('delete');
        Route::post('import', [BarangController::class,'import'])->name('import');
    });
    
    // Barang Masuk
    Route::group(['prefix'=>'admin/barang-masuk','as'=>'admin.barang-masuk.'], function(){
        Route::get('/', [BarangMasukController::class,'index'])->name('index');
        Route::get('check-barang', [BarangMasukController::class,'checkBarang'])->name('checkBarang');
    });
    
    // Masuk Rak
    Route::group(['prefix'=>'admin/masuk-rak','as'=>'admin.masuk-rak.'], function(){
        Route::get('/', [MasukRakController::class,'index'])->name('index');
        Route::get('check-barang', [MasukRakController::class,'checkBarang'])->name('checkBarang');
    });

    // Daftar Barang Keluar
    Route::group(['prefix'=>'daftar-barang-keluar','as'=>'daftar-barang-keluar.'], function(){
        Route::get('/', [DaftarBarangKeluarController::class,'index'])->name('index');
        Route::get('get-data-barang', [DaftarBarangKeluarController::class,'getDataBarang'])->name('getDataBarang');
        Route::post('store', [DaftarBarangKeluarController::class,'store'])->name('store');
        Route::get('delete/{id_barang}', [DaftarBarangKeluarController::class,'delete'])->name('delete');
        Route::post('import', [DaftarBarangKeluarController::class,'import'])->name('import');
    });
    
    // Barang Keluar
    Route::group(['prefix'=>'admin/barang-keluar','as'=>'admin.barang-keluar.'], function(){
        Route::get('/', [BarangKeluarController::class,'index'])->name('index');
        Route::get('check-barang', [BarangKeluarController::class,'checkBarang'])->name('checkBarang');
    });
    
    // Sewa Barang
    Route::group(['prefix'=>'sewa-barang','as'=>'sewa-barang.'], function(){
        Route::get('/', [SewaBarangController::class,'index'])->name('index');
        Route::get('cetak-invoice/{id_barang}', [SewaBarangController::class,'cetakInvoice'])->name('cetak.invoice');
    });
});

Route::middleware(['auth:user'])->group(function () {
    // Profil
    Route::group(['prefix'=>'user/profil','as'=>'user.profil.'], function(){
        Route::get('/', [ProfilController::class,'index'])->name('index');
        Route::post('update', [ProfilController::class,'update'])->name('update');
    });
    
    // Barang Masuk
    Route::group(['prefix'=>'user/barang-masuk','as'=>'user.barang-masuk.'], function(){
        Route::get('/', [BarangMasukController::class,'index'])->name('index');
        Route::get('check-barang', [BarangMasukController::class,'checkBarang'])->name('checkBarang');
        Route::post('update', [BarangMasukController::class,'update'])->name('update');
    });

    // Barang Keluar
    Route::group(['prefix'=>'user/barang-keluar','as'=>'user.barang-keluar.'], function(){
        Route::get('/', [BarangKeluarController::class,'index'])->name('index');
        Route::get('check-barang', [BarangKeluarController::class,'checkBarang'])->name('checkBarang');
    });
});
