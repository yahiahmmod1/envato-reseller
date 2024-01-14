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

Route::post('/keyactivation',[LicenseController::class,'activateProcess'])->name('activation.process');
Route::get('/user/service/{service}',[ServiceController::class,'userService'])->name('service');
Route::post('/user/download/process',[DownloadController::class,'downloadProcess'])->name('download.process');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
