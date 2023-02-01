<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/upload', [AuthController::class, 'upload_login'])->name('login.upload');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register/upload', [AuthController::class, 'upload_register'])->name('register.upload');
Route::get('/reset_password', [AuthController::class, 'reset_password'])->name('reset_password');
Route::post('/reset_password/upload', [AuthController::class, 'upload_reset_password'])->name('reset_password.upload');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'admin','middleware' => ['auth','admin-role']], function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dasboard');
    Route::get('vehicle', [AdminVehicleController::class, 'index'])->name('admin.vehicle');
    Route::post('vehicle/create', [AdminVehicleController::class, 'create'])->name('admin.vehicle.create');
    Route::post('vehicle/update', [AdminVehicleController::class, 'update'])->name('admin.vehicle.update');
    Route::post('vehicle/delete', [AdminVehicleController::class, 'delete'])->name('admin.vehicle.delete');

});

Route::group(['prefix' => 'manager','middleware' => ['auth','manager-role']], function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('manager   .dasboard');
});

