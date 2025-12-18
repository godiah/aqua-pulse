<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MqttController;
use App\Http\Controllers\Api\DeviceLogApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| MQTT Data Endpoints
|--------------------------------------------------------------------------
|
| These routes handle incoming MQTT data from the WebSocket client
|
*/

Route::prefix('mqtt')->group(function () {
    // Receive MQTT data from WebSocket client
    Route::post('/water-level', [MqttController::class, 'waterLevel']);
    Route::post('/flow-rate', [MqttController::class, 'flowRate']);
    Route::post('/pump-status', [MqttController::class, 'pumpStatus']);
    Route::post('/alert', [MqttController::class, 'alert']);

    // Get real-time data
    Route::get('/realtime-data', [MqttController::class, 'getRealtimeData']);

    // Pump control
    Route::post('/control-pump', [MqttController::class, 'controlPump']);
});

/*
|--------------------------------------------------------------------------
| Device Logging Endpoints
|--------------------------------------------------------------------------
|
| These routes handle device logs from MQTT/JavaScript clients
|
*/

Route::prefix('logs')->group(function () {
    // Create a single log entry
    Route::post('/', [DeviceLogApiController::class, 'store']);

    // Batch create log entries
    Route::post('/batch', [DeviceLogApiController::class, 'storeBatch']);

    // Get logs for a specific device
    Route::get('/device/{deviceId}', [DeviceLogApiController::class, 'getDeviceLogs']);
});
