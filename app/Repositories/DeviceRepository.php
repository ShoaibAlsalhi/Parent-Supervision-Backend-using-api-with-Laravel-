<?php

namespace App\Repositories;

use App\Models\Device;

class DeviceRepository
{
    public function getByUserId(int $userId)
    {
        return Device::where('user_id', $userId)->latest()->get();
    }

    public function create(array $data): Device
    {
        return Device::create($data);
    }

    public function delete(int $deviceId, int $userId): bool
    {
        $device = Device::where('id', $deviceId)->where('user_id', $userId)->first();
        
        if ($device) {
            return $device->delete();
        }
        
        return false;
    }
}