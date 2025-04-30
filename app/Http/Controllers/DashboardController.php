<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Hanya user yang login yang bisa mengakses dashboard
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard'); // Mengarah ke resources/views/dashboard.blade.php
    }
}
