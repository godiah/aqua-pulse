<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MqttService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class MqttController extends Controller
{
    protected $mqttService;

    public function __construct(MqttService $mqttService)
    {
        $this->mqttService = $mqttService;
    }

    /**
     * Handle water level data from MQTT
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function waterLevel(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
            'level' => 'required|numeric|min:0|max:100',
            'volume' => 'nullable|numeric',
            'capacity' => 'nullable|numeric',
            'timestamp' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $this->mqttService->handleWaterLevel($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Water level data processed successfully'
        ]);
    }

    /**
     * Handle flow rate data from MQTT
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function flowRate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
            'flow_rate' => 'required|numeric|min:0',
            'timestamp' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $this->mqttService->handleFlowRate($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Flow rate data processed successfully'
        ]);
    }

    /**
     * Handle pump status data from MQTT
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function pumpStatus(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
            'status' => 'required|in:on,off,true,false,0,1',
            'running_time' => 'nullable|string',
            'power_consumption' => 'nullable|numeric',
            'timestamp' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $this->mqttService->handlePumpStatus($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Pump status data processed successfully'
        ]);
    }

    /**
     * Handle alert messages from MQTT
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function alert(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
            'message' => 'required|string',
            'severity' => 'nullable|in:info,warning,error,critical',
            'timestamp' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $this->mqttService->handleAlert($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Alert processed successfully'
        ]);
    }

    /**
     * Get real-time data for a device
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getRealtimeData(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|integer|exists:devices,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $this->mqttService->getRealtimeData($request->device_id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Send pump control command
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function controlPump(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
            'command' => 'required|in:on,off',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $commandData = $this->mqttService->publishPumpCommand(
            $request->device_id,
            $request->command
        );

        return response()->json([
            'success' => true,
            'message' => 'Command prepared',
            'data' => $commandData
        ]);
    }
}
