<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerDashboardController extends Controller
{
     public function index()
    {
        $user = Auth::user();
        // Tambahkan logic manager di sini
        return view('manager.dashboard', compact('user'));
    }
}
