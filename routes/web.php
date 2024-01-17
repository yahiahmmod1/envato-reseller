<?php

use App\Http\Controllers\DownloadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\ServiceController;
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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/user/panel', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
Route::post('/admin/create-license', [AdminController::class, 'createLicense'])->name('admin.createLicense');
Route::get('/admin/license-list', [AdminController::class, 'licenseList'])->name('admin.licenseList');
Route::get('/admin/cookie-setting', [AdminController::class, 'setCookie'])->name('admin.setCookie');
Route::post('/admin/cookie-set-process', [AdminController::class, 'setCookieProcess'])->name('admin.setCookieProcess');
Route::get('/admin/cookie-delete/{id}', [AdminController::class, 'cookieDelete'])->name('admin.cookieDelete');
Route::get('/admin/sell-license/{id}', [AdminController::class, 'sellLicense'])->name('admin.sellLicense');
Route::get('/admin/suspend-license/{id}', [AdminController::class, 'suspendLicense'])->name('admin.suspendLicense');
Route::get('/admin/activate-license/{id}', [AdminController::class, 'activateLicense'])->name('admin.activateLicense');
Route::get('/admin/user-list', [AdminController::class, 'userList'])->name('admin.userList');
Route::get('/admin/user-license/{id}', [AdminController::class, 'userLicense'])->name('admin.userLicense');

Route::post('/keyactivation',[LicenseController::class,'activateProcess'])->name('activation.process');
Route::get('/user/service/{service}',[ServiceController::class,'userService'])->name('service');
Route::post('/user/download/process',[DownloadController::class,'downloadProcess'])->name('download.process');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
