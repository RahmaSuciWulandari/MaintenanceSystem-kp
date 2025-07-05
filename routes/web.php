<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;  // Ubah dari AuthController
use Illuminate\Support\Facades\Auth;

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
    
    // Profile routes
    Route::get('/profile', [LoginController::class, 'profile'])->name('profile');
    Route::put('/profile', [LoginController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [LoginController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('/change-password', [LoginController::class, 'changePassword']);
    
    // Default dashboard - redirect based on role
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if (!$user->role) {
            return view('dashboard');
        }
        
        switch ($user->role->name) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'manager_it':
                return redirect('/manager/dashboard');
            case 'pic_unit':
                return redirect('/pic/dashboard');
            case 'pelaksana':
                return redirect('/pelaksana/dashboard');
            default:
                return view('dashboard');
        }
    })->name('dashboard');
    
    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            $dashboardData = app(LoginController::class)->getDashboardData();
            return view('admin.dashboard', $dashboardData);
        })->name('admin.dashboard');
        
        // User management routes (admin only)
        Route::get('/users', function () {
            return view('admin.users');
        })->name('admin.users');
        
        // System settings routes (admin only)
        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('admin.settings');
    });
    
    // Manager IT routes
    Route::middleware('role:manager_it')->prefix('manager')->group(function () {
        Route::get('/dashboard', function () {
            $dashboardData = app(LoginController::class)->getDashboardData();
            return view('manager.dashboard', $dashboardData);
        })->name('manager.dashboard');
        
        // IT management routes
        Route::get('/tickets', function () {
            return view('manager.tickets');
        })->name('manager.tickets');
        
        Route::get('/reports', function () {
            return view('manager.reports');
        })->name('manager.reports');
    });
    
    // PIC Unit routes
    Route::middleware('role:pic_unit')->prefix('pic')->group(function () {
        Route::get('/dashboard', function () {
            $dashboardData = app(LoginController::class)->getDashboardData();
            return view('pic.dashboard', $dashboardData);
        })->name('pic.dashboard');
        
        // Unit management routes
        Route::get('/requests', function () {
            return view('pic.requests');
        })->name('pic.requests');
        
        Route::get('/inventory', function () {
            return view('pic.inventory');
        })->name('pic.inventory');
    });
    
    // Pelaksana routes
    Route::middleware('role:pelaksana')->prefix('pelaksana')->group(function () {
        Route::get('/dashboard', function () {
            $dashboardData = app(LoginController::class)->getDashboardData();
            return view('pelaksana.dashboard', $dashboardData);
        })->name('pelaksana.dashboard');
        
        // Task management routes
        Route::get('/tasks', function () {
            return view('pelaksana.tasks');
        })->name('pelaksana.tasks');
        
        Route::get('/schedule', function () {
            return view('pelaksana.schedule');
        })->name('pelaksana.schedule');
    });
});