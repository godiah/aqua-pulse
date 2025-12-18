<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of devices.
     */
    public function index()
    {
        $devices = Device::with(['user', 'tenant'])->paginate(15);
        $totalDevices = Device::count();
        $onlineDevices = Device::where('status', 'online')->count();
        $offlineDevices = Device::where('status', 'offline')->count();

        return view('admin.devices.index', compact('devices', 'totalDevices', 'onlineDevices', 'offlineDevices'));
    }

    /**
     * Show the form for creating a new device.
     */
    public function create()
    {
        $users = User::where('role', 'tenant')->get();
        return view('admin.devices.create', compact('users'));
    }

    /**
     * Store a newly created device in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:online,offline'],
            'inflow_status' => ['nullable', 'string', 'max:255'],
        ]);

        $device = Device::create([
            'tenant_id' => $validated['tenant_id'],
            'status' => $validated['status'],
            'inflow_status' => $validated['inflow_status'],
            'last_seen' => $validated['status'] === 'online' ? now() : null,
        ]);

        return redirect()->route('devices.index')
            ->with('success', 'Device created successfully.');
    }

    /**
     * Display the specified device.
     */
    public function show(Device $device)
    {
        $device->load(['user', 'tenant']);
        $recentLogs = $device->logs()->orderBy('logged_at', 'desc')->take(10)->get();
        return view('admin.devices.show', compact('device', 'recentLogs'));
    }

    /**
     * Show the form for editing the specified device.
     */
    public function edit(Device $device)
    {
        $users = User::where('role', 'tenant')->get();
        return view('admin.devices.edit', compact('device', 'users'));
    }

    /**
     * Update the specified device in storage.
     */
    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'tenant_id' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:online,offline'],
            'inflow_status' => ['nullable', 'string', 'max:255'],
        ]);

        $device->tenant_id = $validated['tenant_id'];
        $device->status = $validated['status'];
        $device->inflow_status = $validated['inflow_status'];

        // Update last_seen if status changed to online
        if ($validated['status'] === 'online' && $device->isDirty('status')) {
            $device->last_seen = now();
        }

        $device->save();

        return redirect()->route('devices.index')
            ->with('success', 'Device updated successfully.');
    }

    /**
     * Remove the specified device from storage.
     */
    public function destroy(Device $device)
    {
        // Check if device is linked to a user
        if ($device->user) {
            return redirect()->route('devices.index')
                ->with('error', 'Cannot delete device that is linked to a user. Please unlink it first.');
        }

        $device->delete();

        return redirect()->route('devices.index')
            ->with('success', 'Device deleted successfully.');
    }
}
