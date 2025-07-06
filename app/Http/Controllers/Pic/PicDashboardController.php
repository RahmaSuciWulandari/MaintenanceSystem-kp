<?php

namespace App\Http\Controllers\Pic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PicDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Tambahkan logic pic unit di sini
        return view('pic.dashboard', compact('user'));
    }
}
