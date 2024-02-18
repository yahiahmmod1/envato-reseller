<?php

use App\Http\Controllers\DownloadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EnvatoController;
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
Route::match(['get','post'],'/admin/cookie-edit/{id}', [AdminController::class, 'cookieEdit'])->name('admin.cookieEdit');
Route::get('/admin/sell-license/{id}', [AdminController::class, 'sellLicense'])->name('admin.sellLicense');
Route::get('/admin/suspend-license/{id}', [AdminController::class, 'suspendLicense'])->name('admin.suspendLicense');
Route::get('/admin/activate-license/{id}', [AdminController::class, 'activateLicense'])->name('admin.activateLicense');
Route::get('/admin/user-list', [AdminController::class, 'userList'])->name('admin.userList');
Route::get('/admin/user-license/{id}', [AdminController::class, 'userLicense'])->name('admin.userLicense');
Route::get('/admin/clear-log', [AdminController::class, 'clearLog'])->name('admin.clearLog');

Route::get('/admin/banner-setting', [AdminController::class, 'setBanner'])->name('admin.setBanner');
Route::post('/admin/create-banner', [AdminController::class, 'createBanner'])->middleware('optimizeImages')->name('admin.createBanner');
Route::get('/admin/banner-delete/{id}', [AdminController::class, 'deleteBanner'])->name('admin.deleteBanner');

Route::get('/admin/log-list', [AdminController::class, 'logList'])->name('admin.logList');

Route::post('/keyactivation',[LicenseController::class,'activateProcess'])->name('activation.process');
Route::get('/user/service/{service}',[ServiceController::class,'userService'])->name('service');
Route::post('/user/download/process',[DownloadController::class,'downloadProcess'])->name('download.process');
Route::get('/user/license-download/{id}', [DownloadController::class, 'licenseDownload'])->name('user.licenseDownload');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/envato-test',[EnvatoController::class,'envatoTest'])->name('envatotest');
Route::get('/envato-test2',[EnvatoController::class,'envatoTest2'])->name('envatotest2');
Route::get('/envato-test3',[EnvatoController::class,'envatoTest3'])->name('envatotest3');

Route::get('/test',[DownloadController::class,'testService']);
