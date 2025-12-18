<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeviceLog;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceLogController extends Controller
{
    /**
     * Display a listing of device logs.
     */
    public function index(Request $request)
    {
        $query = DeviceLog::with('device')->orderBy('logged_at', 'desc');

        // Filter by device
        if ($request->filled('device_id')) {
            $query->where('device_id', $request->device_id);
        }

        // Filter by level
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('logged_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('logged_at', '<=', $request->to_date);
        }

        $logs = $query->paginate(20);
        $devices = Device::all();

        // Statistics
        $totalLogs = DeviceLog::count();
        $errorLogs = DeviceLog::errors()->count();
        $criticalLogs = DeviceLog::where('level', 'critical')->count();
        $todayLogs = DeviceLog::whereDate('logged_at', today())->count();

        return view('admin.logs.index', compact('logs', 'devices', 'totalLogs', 'errorLogs', 'criticalLogs', 'todayLogs'));
    }

    /**
     * Display the specified log.
     */
    public function show(DeviceLog $log)
    {
        $log->load('device.user');
        return view('admin.logs.show', compact('log'));
    }

    /**
     * Remove the specified log from storage.
     */
    public function destroy(DeviceLog $log)
    {
        $log->delete();

        return redirect()->route('logs.index')
            ->with('success', 'Log deleted successfully.');
    }

    /**
     * Clear old logs (older than specified days).
     */
    public function clearOld(Request $request)
    {
        $days = $request->input('days', 30);
        $count = DeviceLog::where('logged_at', '<', now()->subDays($days))->delete();

        return redirect()->route('logs.index')
            ->with('success', "Deleted {$count} logs older than {$days} days.");
    }

    /**
     * Clear all logs for a specific device.
     */
    public function clearDevice(Device $device)
    {
        $count = $device->logs()->delete();

        return redirect()->route('logs.index')
            ->with('success', "Deleted {$count} logs for Device #{$device->id}.");
    }
}
