<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\Manager\SubmissionController as ManagerSubmissionController;

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
    Route::get('employee', [EmployeeController::class, 'index'])->name('admin.employee');
    Route::post('employee/create', [EmployeeController::class, 'create'])->name('admin.employee.create');
    Route::post('employee/update', [EmployeeController::class, 'update'])->name('admin.employee.update');
    Route::post('employee/delete', [EmployeeController::class, 'delete'])->name('admin.employee.delete');
    Route::get('submission', [SubmissionController::class, 'index'])->name('admin.submission');
    Route::post('submission/create', [SubmissionController::class, 'create'])->name('admin.submission.create');
    Route::post('submission/update', [SubmissionController::class, 'update'])->name('admin.submission.update');
    Route::post('submission/delete', [SubmissionController::class, 'delete'])->name('admin.submission.delete');
    Route::get('submission/show/{id}', [SubmissionController::class, 'show'])->name('admin.submission.show');
    Route::post('submission/return', [SubmissionController::class, 'return_submission'])->name('admin.submission.return');
    Route::get('submission/history', [SubmissionController::class, 'history'])->name('admin.submission.history');

});

Route::group(['prefix' => 'manager','middleware' => ['auth','manager-role']], function () {
    Route::get('dashboard', [ManagerController::class, 'dashboard'])->name('manager.dasboard');
    Route::get('submission', [ManagerSubmissionController::class, 'index'])->name('manager.submission');
    Route::post('submission/action', [ManagerSubmissionController::class, 'action_submission'])->name('manager.submission.action');
    Route::get('submission/granted', [ManagerSubmissionController::class, 'granted_submission'])->name('manager.submission.granted');
    Route::get('submission/denied', [ManagerSubmissionController::class, 'denied_submission'])->name('manager.submission.denied');
    Route::get('submission/show/{id}', [ManagerSubmissionController::class, 'show'])->name('manager.submission.show');
    Route::get('submission/history', [ManagerSubmissionController::class, 'history'])->name('manager.submission.history');

});

