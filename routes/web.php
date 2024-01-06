<?php

use App\Http\Controllers\DownloadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LicenseController;
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

Route::get('/download', [DownloadController::class, 'getDownload']);
Route::get('/user/panel', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
Route::get('/admin/dashboard', [DashboardController::class, 'userDashboard'])->name('admin.dashboard');
Route::post('/keyactivation',[LicenseController::class,'activateProcess'])->name('activation.process');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
