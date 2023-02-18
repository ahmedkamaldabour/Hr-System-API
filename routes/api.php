<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

// route group for guest
Route::group(['middleware' => ['guest:sanctum']], function () {
	Route::post('/login', [AuthController::class, 'login'])->name('login');
});

// route group for auth
Route::group(['middleware' => ['auth:sanctum']], function () {
	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
	Route::get('/user', [AuthController::class, 'user'])->name('user');
	// branch routes
	Route::get('/branches', [BranchController::class, 'index'])->name('branches');
	Route::post('/branches', [BranchController::class, 'store'])->name('branches.store');
	Route::Put('/branches/{id}', [BranchController::class, 'update'])->name('branches.update');
	Route::delete('/branches/{id}', [BranchController::class, 'destroy'])->name('branches.destroy');
	Route::get('/branches/{id}/employees', [BranchController::class, 'branch_employees'])->name('branches.employees');
	// department routes
	Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
	Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
	Route::Put('/departments/{id}', [DepartmentController::class, 'update'])->name('departments.update');
	Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
	Route::get('/departments/{id}/employees', [DepartmentController::class, 'department_employees'])->name('departments.employees');
	// employee routes
	Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
	Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
	Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
	Route::Put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
	Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');


});