<?php

namespace App\Http\Controllers\Pelaksana;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelaksanaDashboardController extends Controller
{
     public function index()
    {
        $user = Auth::user();
        // Tambahkan logic pelaksana di sini
        return view('pelaksana.dashboard', compact('user'));
    }
}
