<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceLog;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceLogApiController extends Controller
{
    /**
     * Store a new log entry from external sources.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => ['required', 'exists:devices,id'],
            'level' => ['required', 'in:info,warning,error,critical'],
            'message' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],
            'details' => ['nullable'],
            'source' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $log = DeviceLog::create([
            'device_id' => $request->device_id,
            'level' => $request->level,
            'message' => $request->message,
            'type' => $request->type,
            'details' => is_array($request->details) ? $request->details : $request->details,
            'source' => $request->source ?? 'mqtt',
            'logged_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Log created successfully',
            'log' => $log
        ], 201);
    }

    /**
     * Batch store multiple log entries.
     */
    public function storeBatch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logs' => ['required', 'array'],
            'logs.*.device_id' => ['required', 'exists:devices,id'],
            'logs.*.level' => ['required', 'in:info,warning,error,critical'],
            'logs.*.message' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $logs = [];
        foreach ($request->logs as $logData) {
            $logs[] = DeviceLog::create([
                'device_id' => $logData['device_id'],
                'level' => $logData['level'],
                'message' => $logData['message'],
                'type' => $logData['type'] ?? null,
                'details' => $logData['details'] ?? null,
                'source' => $logData['source'] ?? 'mqtt',
                'logged_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => count($logs) . ' logs created successfully',
            'logs' => $logs
        ], 201);
    }

    /**
     * Get logs for a specific device.
     */
    public function getDeviceLogs($deviceId)
    {
        $device = Device::find($deviceId);

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found'
            ], 404);
        }

        $logs = $device->logs()->orderBy('logged_at', 'desc')->paginate(50);

        return response()->json([
            'success' => true,
            'device' => $device,
            'logs' => $logs
        ]);
    }
}
