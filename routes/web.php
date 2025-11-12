<?php

use App\Http\Controllers\AdminSubscriptionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaketController;
use App\Http\Middleware\CheckLevel;
use App\Models\Paket;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProfileVoucherController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\StokVoucherController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Models\Info;
use Illuminate\Http\Request;
use App\Models\Subscription;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===================== HALAMAN UTAMA ===================== //
Route::get('/', function () {
    $pakets = Paket::all();
    return view('welcome', compact('pakets'));
});


// ===================== ROUTE UNTUK USER ===================== //
Route::middleware(['auth', '\App\Http\Middleware\CheckLevel:user'])->group(function () {

    // Dashboard
    Route::get('/instance', function () {
        return view('user.instance');
    })->middleware(['verified'])->name('user.instance');

    // Remote Access
    Route::get('/remote', function () {
        return view('user.remote');
    })->name('user.remote');

    // Billing & Invoice
    Route::get('/invoice', function () {
        return view('user.invoice');
    })->name('user.invoice');

    // Account Settings
    Route::get('/account', function () {
        return view('user.account');
    })->name('user.account');

    // Tambah Instance (Order Page dengan data dinamis dari database)
    Route::get('/order', [PaketController::class, 'showForUser'])->name('user.order');

    // Subscription
    Route::get('/subs', [SubscriptionController::class, 'create'])->name('subscription.create');
    Route::post('/subs', [SubscriptionController::class, 'store'])->name('subscription.store');

    Route::get('/subscriptions/user/json', [SubscriptionController::class, 'userSubscriptionsJson'])
        ->middleware('auth')
        ->name('subscription.user.json');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ===================== ROUTE UNTUK ADMIN ===================== //

Route::middleware(['auth', CheckLevel::class . ':admin'])->group(function () {

    // ===== Dashboard Admin (Daftar Subscription) =====
    Route::get('/admin/dashboard', [AdminSubscriptionController::class, 'index'])
        ->name('admin.dashboard');

    // ===== Update Status Subscription =====
    Route::put('/admin/subscription/{id}/update-status', [AdminSubscriptionController::class, 'updateStatus'])
        ->name('admin.subscription.updateStatus');

    // ===== Hapus Subscription =====
    Route::delete('/admin/subscription/{id}', [AdminSubscriptionController::class, 'destroy'])
        ->name('admin.subscription.destroy');

    // ===== CRUD PAKET =====
    Route::get('/admin/paket/index', [PaketController::class, 'index'])->name('paket.index');
    Route::get('/admin/paket/create', [PaketController::class, 'create'])->name('paket.create');
    Route::post('/admin/paket/store', [PaketController::class, 'store'])->name('paket.store');
    Route::get('/admin/paket/{id}/edit', [PaketController::class, 'edit'])->name('paket.edit');
    Route::put('/admin/paket/{id}', [PaketController::class, 'update'])->name('paket.update');
    Route::delete('/admin/paket/{id}', [PaketController::class, 'destroy'])->name('paket.destroy');
});




// ===================== ROUTE UNTUK RESELLER ===================== //
Route::get('/reseller', [ResellerController::class, 'index'])->name('resellers.index');
Route::get('/reseller/create', [ResellerController::class, 'create'])->name('resellers.create');
Route::post('/reseller/store', [ResellerController::class, 'store'])->name('resellers.store');
Route::get('/reseller/{id}/edit', [ResellerController::class, 'edit'])->name('resellers.edit');
Route::put('/reseller/{id}', [ResellerController::class, 'update'])->name('resellers.update');
Route::delete('/reseller/{id}', [ResellerController::class, 'destroy'])->name('resellers.delete');


// ===================== ROUTE UNTUK VOUCHER ===================== //
Route::get('/voucher', [ProfileVoucherController::class, 'index'])->name('voucher.index');
Route::get('/voucher/create', [ProfileVoucherController::class, 'create'])->name('voucher.create');
Route::post('/voucher/store', [ProfileVoucherController::class, 'store'])->name('voucher.store');
Route::get('/voucher/{id}/edit', [ProfileVoucherController::class, 'edit'])->name('voucher.edit');
Route::put('/voucher/{id}', [ProfileVoucherController::class, 'update'])->name('voucher.update');
Route::delete('/voucher/{id}', [ProfileVoucherController::class, 'destroy'])->name('voucher.delete');


// ===================== ROUTE UNTUK STOK VOUCHER ===================== //
Route::get('/stokvoucher', [StokVoucherController::class, 'index'])->name('stokvoucher.index');
Route::get('/stokvoucher/create', [StokVoucherController::class, 'create'])->name('stokvoucher.create');
Route::post('/stokvoucher/store', [StokVoucherController::class, 'store'])->name('stokvoucher.store');
Route::get('/stokvoucher/{id}/edit', [StokVoucherController::class, 'edit'])->name('stokvoucher.edit');
Route::put('/stokvoucher/{id}', [StokVoucherController::class, 'update'])->name('stokvoucher.update');
Route::delete('/stokvoucher/{id}', [StokVoucherController::class, 'destroy'])->name('stokvoucher.delete');


// ===================== ROUTE UNTUK ROUTER ===================== //
Route::resource('routers', RouterController::class);
Route::get('routers/{id}/download', [RouterController::class, 'downloadScript'])->name('routers.download');
Route::get('routers/{id}/snmp', [RouterController::class, 'checkSnmp'])->name('routers.snmp');
// Route::get('/router/{id}/download-ovpn', [RouterController::class, 'downloadOVPN'])->name('routers.download.ovpn');
// Route::get('/router/{id}/view-ovpn', [RouterController::class, 'viewOVPN'])->name('routers.view.ovpn');



// ===================== ROUTE UNTUK ADMIN-SUB ===================== //
// Route::get('/dashboard', fn () => view('admin-sub.dashboard'))->name('admin-sub.dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin-sub.dashboard');
});



//Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');//


// Log Activity
Route::get('/info', [InfoController::class, 'index'])->name('info.index');
Route::delete('/info/destroy-all', [InfoController::class, 'destroyAll'])->name('info.destroyAll');

// Route::middleware(['auth', 'can:isAdmin'])->group(function () {
//     Route::get('/admin', [RegisteredUserController::class, 'createSubadmin'])->name('subadmin.create');
//     Route::post('/admin', [RegisteredUserController::class, 'storeSubadmin'])->name('subadmin.store');
// });

// Route::middleware('auth')->group(function () {
//     // Create
//     Route::get('/admin/create', [RegisteredUserController::class, 'createSubadmin'])->name('subadmin.create');
//     Route::post('/admin/store', [RegisteredUserController::class, 'storeSubadmin'])->name('subadmin.store');

//     // Read
//     Route::get('/admin', [RegisteredUserController::class, 'createSubadmin'])->name('subadmin.admin');

//     // Edit
//     Route::get('/admin/edit/{id}', [RegisteredUserController::class, 'editSubadmin'])->name('subadmin.edit');
//     Route::put('/admin/update/{id}', [RegisteredUserController::class, 'updateSubadmin'])->name('subadmin.update');

//     // Delete
//     Route::delete('/admin/delete/{id}', [RegisteredUserController::class, 'deleteSubadmin'])->name('subadmin.delete');
// });

//create
Route::get('/admin/create', [RegisteredUserController::class, 'createSubadmin'])->name('subadmin.create');
Route::post('/admin/store', [RegisteredUserController::class, 'storeSubadmin'])->name('subadmin.store');

// Read
Route::get('/admin', [RegisteredUserController::class, 'createSubadmin'])->name('subadmin.admin');

// Edit
Route::get('/admin/edit/{id}', [RegisteredUserController::class, 'editSubadmin'])->name('subadmin.edit');
Route::put('/admin/update/{id}', [RegisteredUserController::class, 'updateSubadmin'])->name('subadmin.update');

// Delete
Route::delete('/admin/delete/{id}', [RegisteredUserController::class, 'deleteSubadmin'])->name('subadmin.delete');


Route::get('/transaksi', [TransaksiController::class, 'index'])->name('subadmin.transaksi');
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');


// ===================== API TESTING ROUTES ===================== //
// Route::get('/api/reseller/{id}', function ($id) {
//     return \App\Models\Reseller::findOrFail($id);
// });

// Route::get('/api/profile-voucher/{id}', function ($id) {
//     return \App\Models\ProfileVoucher::findOrFail($id);
// });


// ===================== REDIRECT DASHBOARD ===================== //
// Route::get('/dashboard', function () {
//     return redirect()->route('admin.dashboard');
// })->name('dashboard');


// ===================== ROUTE AUTH (Laravel Breeze) ===================== //
require __DIR__ . '/auth.php';
