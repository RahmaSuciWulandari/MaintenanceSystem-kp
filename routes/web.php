<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Manager\ManagerDashboardController;
use App\Http\Controllers\Pic\PicDashboardController;
use App\Http\Controllers\Pelaksana\PelaksanaDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes for authentication, profile management, and role-based dashboards.
|
*/

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Profile
    Route::get('/profile', [LoginController::class, 'profile'])->name('profile');
    Route::put('/profile', [LoginController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [LoginController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('/change-password', [LoginController::class, 'changePassword']);

    // Role-based dashboard redirection
    Route::get('/dashboard', function () {
        $user = Auth::user();

        return match ($user->role->name ?? '') {
            'admin'        => redirect()->route('admin.dashboard'),
            'manager_it'   => redirect()->route('manager.dashboard'),
            'pic_unit'     => redirect()->route('pic.dashboard'),
            'pelaksana'    => redirect()->route('pelaksana.dashboard'),
            default        => view('dashboard'),
        };
    })->name('dashboard');

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
        //Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        //Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    });

    // Manager IT routes
    Route::middleware('role:manager_it')->prefix('manager')->group(function () {
        Route::get('/dashboard', [ManagerDashboardController::class, 'dashboard'])->name('manager.dashboard');
        //Route::get('/tickets', [ManagerController::class, 'tickets'])->name('manager.tickets');
        //Route::get('/reports', [ManagerController::class, 'reports'])->name('manager.reports');
    });

    // PIC Unit routes
    Route::middleware('role:pic_unit')->prefix('pic')->group(function () {
        Route::get('/dashboard', [PicDashboardController::class, 'dashboard'])->name('pic.dashboard');
        //Route::get('/requests', [PicController::class, 'requests'])->name('pic.requests');
       // Route::get('/inventory', [PicController::class, 'inventory'])->name('pic.inventory');
    });

    // Pelaksana routes
    Route::middleware('role:pelaksana')->prefix('pelaksana')->group(function () {
        Route::get('/dashboard', [PelaksanaDashboardController::class, 'dashboard'])->name('pelaksana.dashboard');
        //Route::get('/tasks', [PelaksanaController::class, 'tasks'])->name('pelaksana.tasks');
        //Route::get('/schedule', [PelaksanaController::class, 'schedule'])->name('pelaksana.schedule');
    });
});
