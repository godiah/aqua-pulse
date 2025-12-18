<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Device;
use App\Models\DeviceLog;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalDevices = Device::count();
        $activeDevices = Device::where('status', 'online')->count();
        $offlineDevices = Device::where('status', 'offline')->count();
        $tenantUsers = User::where('role', 'tenant')->count();
        $adminUsers = User::where('role', 'super_admin')->count();

        $recentUsers = User::with('device')->latest()->take(5)->get();
        $recentDevices = Device::with('user')->latest()->take(5)->get();
        $recentLogs = DeviceLog::with('device')->orderBy('logged_at', 'desc')->take(5)->get();
        $errorCount = DeviceLog::errors()->count();

        return view('adminDashboard', compact(
            'totalUsers', 'totalDevices', 'activeDevices', 'offlineDevices',
            'tenantUsers', 'adminUsers', 'recentUsers', 'recentDevices', 'recentLogs', 'errorCount'
        ));
    }
}
