<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BenefitMembershipController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PelangganMemberController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RiwayatTransaksiController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RbacMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
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
Route::get('/access-denied', function () {
    return view('access-denied');
})->name('access_denied');
Route::get('/lupa-password', function () {
    return view('auth.lupa-password');
})->name('lupa-password');
Route::get('/lupa-password/handle', [AuthController::class, 'lupaPasswordHandle'])->name('lupa-password.handle');
Route::post('/lupa-password/handle/update/{id?}', [AuthController::class, 'lupaPasswordUpdate'])->name('lupa-password.handle.update');
Route::middleware([RedirectIfAuthenticated::class])->group(function() {
    Route::get('/login', [AuthController::class,'indexLogin'])->name('login');
    Route::get('/register', [AuthController::class,'indexRegister'])->name('register');
    Route::post('/login', [AuthController::class,'handleLogin'])->name('login');
    Route::post('/register', [AuthController::class, 'handleRegister'])->name('register');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware([RbacMiddleware::class])->group(function() {
        Route::middleware([Authenticate::class])->group(function() {
            Route::prefix('akun')->name('akun.')->group(function() {
            Route::get('setting', [AkunController::class, 'setting'])->name('setting');
            Route::get('/setting/save', [AkunController::class, 'save'])->name('setting.save');
        });
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('produk')->group(function () {
            Route::get('/', [ProdukController::class, 'index'])->name('produk');

            Route::name('produk.')->group(function() {
                Route::get('create', [ProdukController::class, 'create'])->name('create');
                Route::post('store', [ProdukController::class, 'store'])->name('store');
                Route::get('detail/{id?}', [ProdukController::class, 'detail'])->name('detail');
                Route::get('edit/{id?}', [ProdukController::class, 'edit'])->name('edit');
                Route::post('update/{id?}', [ProdukController::class, 'update'])->name('update');
                Route::post('active/{id?}', [ProdukController::class, 'active'])->name('active');
                Route::get('delete/{id?}', [ProdukController::class, 'delete'])->name('delete');
            });
        });

        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('user');

            Route::name('user.')->group(function() {
                Route::get('create', [UserController::class, 'create'])->name('create');
                Route::post('store', [UserController::class, 'store'])->name('store');
                Route::get('detail/{id?}', [UserController::class, 'detail'])->name('detail');
                Route::get('edit/{id?}', [UserController::class, 'edit'])->name('edit');
                Route::post('update/{id?}', [UserController::class, 'update'])->name('update');
                Route::get('delete/{id?}', [UserController::class, 'delete'])->name('delete');
            });
        });

        Route::prefix('role')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('role');

            Route::name('role.')->group(function() {
                Route::get('create', [RoleController::class, 'create'])->name('create');
                Route::post('store', [RoleController::class, 'store'])->name('store');
                Route::get('detail/{id?}', [RoleController::class, 'detail'])->name('detail');
                Route::get('edit/{id?}', [RoleController::class, 'edit'])->name('edit');
                Route::post('update/{id?}', [RoleController::class, 'update'])->name('update');
                Route::get('permission/{id?}', [RoleController::class, 'permission'])->name('permission');
                Route::post('permission/save/{id?}', [RoleController::class, 'savePermission'])->name('permission.save');
                Route::get('delete/{id?}', [RoleController::class, 'delete'])->name('delete');
            });
        });

        Route::prefix('kategori')->group(function () {
            Route::get('/', [KategoriController::class, 'index'])->name('kategori');

            Route::name('kategori.')->group(function() {
                Route::get('create', [KategoriController::class, 'create'])->name('create');
                Route::post('store', [KategoriController::class, 'store'])->name('store');
                Route::get('detail/{id?}', [KategoriController::class, 'detail'])->name('detail');
                Route::get('edit/{id?}', [KategoriController::class, 'edit'])->name('edit');
                Route::post('update/{id?}', [KategoriController::class, 'update'])->name('update');
                Route::get('delete/{id?}', [KategoriController::class, 'delete'])->name('delete');
            });
        });

        Route::prefix('diskon')->group(function () {
            Route::get('/', [DiskonController::class, 'index'])->name('diskon');

            Route::name('diskon.')->group(function() {
                Route::get('edit/{id?}', [DiskonController::class, 'edit'])->name('edit');
                Route::post('update/{id?}', [DiskonController::class, 'update'])->name('update');
                Route::post('active/{id?}', [DiskonController::class, 'active'])->name('active');
                Route::get('delete/{id?}', [DiskonController::class, 'delete'])->name('delete');
            });
        });

        Route::prefix('transaksi')->group(function () {
            Route::get('/', [TransaksiController::class, 'index'])->name('transaksi');

            Route::name('transaksi.')->group(function() {
                Route::get('edit/{id?}', [TransaksiController::class, 'edit'])->name('edit');
                Route::post('store', [TransaksiController::class, 'store'])->name('store');
                Route::post('update/{id?}', [TransaksiController::class, 'update'])->name('update');
                Route::post('active/{id?}', [TransaksiController::class, 'active'])->name('active');
                Route::get('browse/{id_input?}', [TransaksiController::class, 'browse'])->name('browse');
                Route::get('delete/{id?}', [TransaksiController::class, 'delete'])->name('delete');
                Route::get('konfirmasi_pembayaran', [TransaksiController::class, 'konfirmasiPembayaran'])->name('konfirmasi_pembayaran');
            });
        });

        Route::prefix('riwayat_transaksi')->group(function () {
            Route::get('/', [RiwayatTransaksiController::class, 'index'])->name('riwayat_transaksi');

            Route::name('riwayat_transaksi.')->group(function() {
                Route::get('detail/{id?}', [RiwayatTransaksiController::class, 'detail'])->name('detail');
                Route::get('nota/{id?}', [RiwayatTransaksiController::class, 'nota'])->name('nota');
            });
        });

        Route::prefix('pelanggan')->group(function () {
            Route::get('/', [PelangganController::class, 'index'])->name('pelanggan');

            Route::name('pelanggan.')->group(function() {
                Route::get('find_json/{id?}', [PelangganController::class, 'findJson'])->name('find_json');
                Route::get('detail/{id?}', [PelangganController::class, 'detail'])->name('detail');
                Route::get('create/{id?}', [PelangganController::class, 'create'])->name('create');
                Route::get('edit/{id?}', [PelangganController::class, 'edit'])->name('edit');
                Route::post('update/{id?}', [PelangganController::class, 'update'])->name('update');
                Route::post('store/{id?}', [PelangganController::class, 'store'])->name('store');
                Route::post('active/{id?}', [PelangganController::class, 'active'])->name('active');
                Route::get('delete/{id?}', [PelangganController::class, 'delete'])->name('delete');
            });
        });

        Route::prefix('pelanggan_membership')->group(function () {
            Route::get('/', [PelangganMemberController::class, 'index'])->name('pelanggan_membership');

            Route::name('pelanggan_membership.')->group(function() {
                Route::get('create', [PelangganMemberController::class, 'create'])->name('create');
                Route::get('edit/{id?}', [PelangganMemberController::class, 'edit'])->name('edit');
                Route::post('store', [PelangganMemberController::class, 'store'])->name('store');
                Route::post('update/{id?}', [PelangganMemberController::class, 'update'])->name('update');
                Route::get('delete/{id?}', [PelangganMemberController::class, 'delete'])->name('delete');
            });
        });

        Route::prefix('benefit_membership')->group(function () {
            Route::get('/', [BenefitMembershipController::class, 'index'])->name('benefit_membership');

            Route::name('benefit_membership.')->group(function() {
                Route::get('edit/{id?}', [BenefitMembershipController::class, 'edit'])->name('edit');
                Route::get('create', [BenefitMembershipController::class, 'create'])->name('create');
                Route::get('detail/{id?}', [BenefitMembershipController::class, 'detail'])->name('detail');
                Route::post('store', [BenefitMembershipController::class, 'store'])->name('store');
                Route::post('update/{id?}', [BenefitMembershipController::class, 'update'])->name('update');
                Route::post('active/{id?}', [BenefitMembershipController::class, 'active'])->name('active');
                Route::get('browse/{id_input?}', [BenefitMembershipController::class, 'browse'])->name('browse');
                Route::get('delete/{id?}', [BenefitMembershipController::class, 'delete'])->name('delete');
                Route::get('get_benefit_json/{id?}', [BenefitMembershipController::class, 'pelangganBenefitMembershipJson'])->name('get_benefit_json');
            });
        });
    });
});
