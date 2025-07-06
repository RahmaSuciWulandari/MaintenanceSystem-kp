<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Tambahkan logic untuk ambil data admin jika perlu
        return view('admin.dashboard', compact('user'));
    }
}
