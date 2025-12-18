<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the tenant dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        $deviceId = $user->device_id;

        return view('dashboard', compact('deviceId'));
    }
}
