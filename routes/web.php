<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ZoningController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\BarangayCensusController;
use App\Http\Controllers\LandmarkController;
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
Route::get('login', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/register', function () { return Inertia::render('Auth/Register'); })->name('home');
Route::get('/home', function () { return Inertia::render('Home/Index'); })->name('home');
Route::get('/complaint', function () { return Inertia::render('Complaint/Index'); })->name('complaint');
Route::get('/mapping', function () { return Inertia::render('Mapping/Index'); })->name('mapping');


Route::middleware('auth')->group(function () {

    Route::prefix('dashboard/')->group(function(){
        Route::get('', [DashboardController::class, 'index'])->name('dashboard.index');
    });
    Route::prefix('census/')->group(function(){
        Route::get('barangay-census', [BarangayCensusController::class, 'index'])->name('barangay.census.index');
        Route::post('barangay-census', [BarangayCensusController::class, 'listCensusData'])->name('barangay.census.list');
       
        Route::post('', [BarangayCensusController::class, 'addCensus'])->name('barangay.census.add');
        Route::patch('/{id}', [BarangayCensusController::class, 'updateCensus'])->name('barangay.census.update');
        Route::delete('/{id}', [BarangayCensusController::class, 'deleteCensus'])->name('barangay.census.delete');
        // API Route for Chart.js
        Route::get('barangay-census-chart-data', [BarangayCensusController::class, 'chartData'])->name('barangay.census.chart');
    });
    Route::prefix('landmarks/')->group(function () {
        Route::get('', [LandmarkController::class, 'index'])->name('landmarks.index');
        Route::post('list', [LandmarkController::class, 'listLandmarks'])->name('landmarks.list');
        Route::post('', [LandmarkController::class, 'add'])->name('landmarks.add');
        Route::patch('{id}', [LandmarkController::class, 'update'])->name('landmarks.update');
        Route::delete('{id}', [LandmarkController::class, 'deleteLandmarks'])->name('landmarks.delete');
    });
    Route::prefix('zonal-map/')->group(function(){
        Route::get('', [ZoningController::class, 'map'])->name('maps.index');
    });
    Route::prefix('logs/')->group(function(){
        Route::get('', [LogsController::class, 'index'])->name('logs.index');
        Route::post('list', [LogsController::class, 'listLogs'])->name('logs.list');
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
        Route::post('users-list', [UserController::class, 'list'])->name('users.list');
        Route::post('users-add', [UserController::class, 'add'])->name('users.add');
        
        Route::delete('{id}', [UserController::class, 'deleteUser'])->name('users.delete');
    });
    Route::prefix('profile/')->group(function(){
        Route::get('', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';
