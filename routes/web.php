<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ExpensesCategoriesController;
use Illuminate\Support\Facades\Auth;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $auth = Auth::user();
    return Inertia::render('Dashboard', [ 'role_id'=>$auth->role_id ]);
})->name('dashboard');
// Roles management Routes***
Route::middleware([ 'auth:sanctum', 'verified' ])->get('/RolesManagement', [ RolesController::class, 'index' ])->name('RolesManagement');
Route::middleware([ 'auth:sanctum', 'verified' ])->prefix('/role')->group(function(){
    Route::post('/store', [ RolesController::class, 'store' ]);
    Route::put('/{id}', [ RolesController::class, 'update' ]);
    Route::delete('/{id}', [ RolesController::class, 'destroy' ]);
});
// User management route***
Route::middleware([ 'auth:sanctum', 'verified', 'IsAdministrator' ])->get('/UsersManagement', [ UsersController::class, 'index' ])->name('UsersManagement');
Route::middleware([ 'auth:sanctum', 'verified', 'IsAdministrator' ])->prefix('/user')->group(function(){
    Route::post('/store', [ UsersController::class, 'store' ]);
    Route::put('/{id}', [ UsersController::class, 'update' ]);
    Route::delete('/{id}', [ UsersController::class, 'destroy' ]);
});
// Expenses management route***
Route::middleware([ 'auth:sanctum', 'verified' ])->get('/ExpensesManagement', [ ExpensesController::class, 'index' ])->name('ExpensesManagement');
Route::middleware([ 'auth:sanctum', 'verified' ])->prefix('/expense')->group(function(){
    Route::post('/store', [ ExpensesController::class, 'store' ]);
    Route::put('/{id}', [ ExpensesController::class, 'update' ]);
    Route::delete('/{id}', [ ExpensesController::class, 'destroy' ]);
});

// Expenses categories route***
Route::middleware([ 'auth:sanctum', 'verified' ])->get('/ExpensesCategories', [ ExpensesCategoriesController::class, 'index' ])->name('ExpensesCategories');
Route::middleware([ 'auth:sanctum', 'verified' ])->prefix('/expCategory')->group(function(){
    Route::post('/store', [ ExpensesCategoriesController::class, 'store' ]);
    Route::put('/{id}', [ ExpensesCategoriesController::class, 'update' ]);
    Route::delete('/{id}', [ ExpensesCategoriesController::class, 'destroy' ]);
});
