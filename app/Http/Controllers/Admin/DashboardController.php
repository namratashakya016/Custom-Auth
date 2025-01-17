<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function index()
    {
        $token = Auth::user()->createToken('LaravelApp')->plainTextToken;
        return view('layouts.dashboard', ['token' => $token]);
    }
}
