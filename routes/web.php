<?php

use App\Http\Controllers\AtributBarang\BrandController;
use App\Http\Controllers\AtributBarang\ProjectController;
use App\Http\Controllers\AtributBarang\UnitController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\JsonController;
use App\Http\Controllers\MasterData\CustomerController;
use App\Http\Controllers\MasterData\SupplierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Stock\AdjustmentStockController;
use App\Http\Controllers\Stock\CriticalStockController;
use App\Http\Controllers\Stock\ReportController;
use App\Http\Controllers\Stock\StockInController;
use App\Http\Controllers\Stock\StockOutController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('logs');
    Route::get('/getJson/{id}', [JsonController::class, 'getJson']);


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    * User
    */
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/form', [UserController::class, 'form'])->name('user.create');
    Route::get('/user/form/{id}', [UserController::class, 'form'])->name('user.edit');
    Route::post('/user/form', [UserController::class, 'store'])->name('user.add');
    Route::post('/user/form/{id}', [UserController::class, 'store'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'delete'])->name('user.delete');

    Route::prefix('/atributBarang')->group(function () {
        /*
        * Project
        */
        Route::get('/proyek', [ProjectController::class, 'index'])->name('proyek.index');
        Route::get('/proyek/form', [ProjectController::class, 'form'])->name('proyek.create');
        Route::get('/proyek/form/{id}', [ProjectController::class, 'form'])->name('proyek.edit');
        Route::post('/proyek/form', [ProjectController::class, 'store'])->name('proyek.add');
        Route::post('/proyek/form/{id}', [ProjectController::class, 'store'])->name('proyek.update');
        Route::delete('/proyek/{id}', [ProjectController::class, 'delete'])->name('proyek.delete');

        /*
        * Brand
        */
        Route::get('/merek', [BrandController::class, 'index'])->name('merek.index');
        Route::get('/merek/form', [BrandController::class, 'form'])->name('merek.create');
        Route::get('/merek/form/{id}', [BrandController::class, 'form'])->name('merek.edit');
        Route::post('/merek/form', [BrandController::class, 'store'])->name('merek.add');
        Route::post('/merek/form/{id}', [BrandController::class, 'store'])->name('merek.update');
        Route::delete('/merek/{id}', [BrandController::class, 'delete'])->name('merek.delete');

        /*
        * Unit
        */
        Route::get('/satuan', [UnitController::class, 'index'])->name('satuan.index');
        Route::get('/satuan/form', [UnitController::class, 'form'])->name('satuan.create');
        Route::get('/satuan/form/{id}', [UnitController::class, 'form'])->name('satuan.edit');
        Route::post('/satuan/form', [UnitController::class, 'store'])->name('satuan.add');
        Route::post('/satuan/form/{id}', [UnitController::class, 'store'])->name('satuan.update');
        Route::delete('/satuan/{id}', [UnitController::class, 'delete'])->name('satuan.delete');
    });

    Route::prefix('/masterData')->group(function () {
        /*
        * Supplier
        */
        Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('/supplier/form', [SupplierController::class, 'form'])->name('supplier.create');
        Route::get('/supplier/form/{id}', [SupplierController::class, 'form'])->name('supplier.edit');
        Route::post('/supplier/form', [SupplierController::class, 'store'])->name('supplier.add');
        Route::post('/supplier/form/{id}', [SupplierController::class, 'store'])->name('supplier.update');
        Route::delete('/supplier/{id}', [SupplierController::class, 'delete'])->name('supplier.delete');

        /*
        * Custumer
        */
        Route::get('/pelanggan', [CustomerController::class, 'index'])->name('pelanggan.index');
        Route::get('/pelanggan/form', [CustomerController::class, 'form'])->name('pelanggan.create');
        Route::get('/pelanggan/form/{id}', [CustomerController::class, 'form'])->name('pelanggan.edit');
        Route::post('/pelanggan/form', [CustomerController::class, 'store'])->name('pelanggan.add');
        Route::post('/pelanggan/form/{id}', [CustomerController::class, 'store'])->name('pelanggan.update');
        Route::delete('/pelanggan/{id}', [CustomerController::class, 'delete'])->name('pelanggan.delete');
    });

    /*
    * Goods
    */
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/form', [BarangController::class, 'form'])->name('barang.create');
    Route::get('/barang/form/{id}', [BarangController::class, 'form'])->name('barang.edit');
    Route::post('/barang/form', [BarangController::class, 'store'])->name('barang.add');
    Route::post('/barang/form/{id}', [BarangController::class, 'store'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangController::class, 'delete'])->name('barang.delete');

    Route::prefix('/stok')->group(function () {
        /*
        * Stock In
        */
        Route::get('/masuk', [StockInController::class, 'index'])->name('masuk.index');
        Route::get('/masuk/add', [StockInController::class, 'add'])->name('masuk.create');
        Route::post('/masuk/cart', [StockInController::class, 'cart'])->name('masuk.cart');
        Route::post('/masuk/cart/{id}', [StockInController::class, 'updateCart'])->name('masuk.cart.update');
        Route::delete('/masuk/cart/delete/{id}', [StockInController::class, 'deleteCart'])->name('masuk.cart.delete');
        Route::post('/masuk/add', [StockInController::class, 'store'])->name('masuk.add');
        Route::delete('/masuk/{id}', [StockInController::class, 'delete'])->name('masuk.delete');
        Route::get('/masuk/{id}', [StockInController::class, 'detail'])->name('masuk.detail');

        /*
        * Stock Out
        */
        Route::get('/keluar', [StockOutController::class, 'index'])->name('keluar.index');
        Route::get('/keluar/add', [StockOutController::class, 'add'])->name('keluar.create');
        Route::post('/keluar/cart', [StockOutController::class, 'cart'])->name('keluar.cart');
        Route::post('/keluar/cart/{id}', [StockOutController::class, 'updateCart'])->name('keluar.cart.update');
        Route::delete('/keluar/cart/delete/{id}', [StockOutController::class, 'deleteCart'])->name('keluar.cart.delete');
        Route::post('/keluar/add', [StockOutController::class, 'store'])->name('keluar.add');
        Route::delete('/keluar/{id}', [StockOutController::class, 'delete'])->name('keluar.delete');
        Route::get('/keluar/{id}', [StockOutController::class, 'detail'])->name('keluar.detail');

        /*
        * Stock Out
        */
        Route::get('/penyesuaian/stok', [AdjustmentStockController::class, 'index'])->name('penyesuaian.stok.index');
        Route::get('/penyesuaian/stok/add', [AdjustmentStockController::class, 'add'])->name('penyesuaian.stok.create');
        Route::post('/penyesuaian/stok/cart', [AdjustmentStockController::class, 'cart'])->name('penyesuaian.stok.cart');
        Route::post('/penyesuaian/stok/cart/{id}', [AdjustmentStockController::class, 'updateCart'])->name('penyesuaian.stok.cart.update');
        Route::delete('/penyesuaian/stok/cart/delete/{id}', [AdjustmentStockController::class, 'deleteCart'])->name('penyesuaian.stok.cart.delete');
        Route::post('/penyesuaian/stok/add', [AdjustmentStockController::class, 'store'])->name('penyesuaian.stok.add');
        Route::get('/penyesuaian/stok/detail/{id}', [AdjustmentStockController::class, 'detail'])->name('penyesuaian.stok.detail');

        /*
        * Report
        */
        Route::get('/report', [ReportController::class, 'index'])->name('report.index');
        Route::get('/report/masuk', [ReportController::class, 'stockIn'])->name('report.stockIn');
        Route::get('/report/Keluar', [ReportController::class, 'stockOut'])->name('report.stockOut');
        Route::get('/report/penyesuaian', [ReportController::class, 'adjustmentStock'])->name('report.adjustmentStock');
        Route::get('/report/{id}', [ReportController::class, 'detail'])->name('report.detail');


        /*
        * Crirical Stock
        */
        Route::get('/kritis', [CriticalStockController::class, 'index'])->name('stock.kritis.index');
    });
});

require __DIR__ . '/auth.php';
