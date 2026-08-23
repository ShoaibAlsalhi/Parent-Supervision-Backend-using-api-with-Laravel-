<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Device\StoreDeviceRequest;
use App\Http\Resources\DeviceResource;
use App\Services\DeviceService;
use Illuminate\Http\JsonResponse;

class DeviceController extends Controller
{
    protected DeviceService $deviceService;

    public function __construct(DeviceService $deviceService)
    {
        $this->deviceService = $deviceService;
    }

    public function index(): JsonResponse
    {
        $devices = $this->deviceService->getUserDevices(auth()->user());

        return response()->json([
            'status' => 'success',
            'data' => DeviceResource::collection($devices)
        ], 200);
    }

    public function store(StoreDeviceRequest $request): JsonResponse
    {
        $device = $this->deviceService->addDevice(auth()->user(), $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'تم إضافة الجهاز بنجاح',
            'data' => new DeviceResource($device)
        ], 201);
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->deviceService->removeDevice(auth()->user(), $id);
            return response()->json([
                'status' => 'success',
                'message' => 'تم حذف الجهاز بنجاح'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 403);
        }
    }
}