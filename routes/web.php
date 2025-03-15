<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ZoningController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {

    

    Route::prefix('dashboard/')->group(function(){
        Route::get('', [DashboardController::class, 'index'])->name('dashboard.index');
    });
    Route::prefix('zoning/')->group(function(){
        Route::get('', [ZoningController::class, 'index'])->name('zoning.index');
        Route::post('list-rejected', [ZoningController::class, 'listRejected'])->name('zoning.rejected.list'); // List with pagination
        Route::post('list-approved', [ZoningController::class, 'listApproved'])->name('zoning.approved.list'); // List with pagination
        Route::post('list-pending', [ZoningController::class, 'listPending'])->name('zoning.pending.list'); // List with pagination
        Route::post('add', [ZoningController::class, 'add'])->name('zoning.add'); // Add new zoning permit with file upload
        Route::put('approve/{id}', [ZoningController::class, 'approve'])->name('zoning.approve'); // Approve permit
        Route::put('reject/{id}', [ZoningController::class, 'reject'])->name('zoning.reject'); // Reject permit
    });
    Route::prefix('landmark/')->group(function(){
        Route::get('', [LandMarkController::class, 'index'])->name('landmark.index');
    });
    Route::prefix('users/')->group(function(){
        Route::get('', [UserController::class, 'index'])->name('users.index');
    });
    Route::prefix('profile/')->group(function(){
        Route::get('', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';
