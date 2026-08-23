<?php

namespace App\Services;

use App\Repositories\DeviceRepository;
use Exception;

class DeviceService
{
    protected DeviceRepository $deviceRepository;

    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }

    public function getUserDevices($user)
    {
        return $this->deviceRepository->getByUserId($user->id);
    }

    public function addDevice($user, array $data)
    {
        // إضافة الـ user_id تلقائياً للبيانات
        $data['user_id'] = $user->id;
        $data['last_seen_at'] = now();
        $data['is_online'] = true;

        return $this->deviceRepository->create($data);
    }

    public function removeDevice($user, int $deviceId)
    {
        $deleted = $this->deviceRepository->delete($deviceId, $user->id);
        
        if (! $deleted) {
            throw new Exception('الجهاز غير موجود أو لا تملك صلاحية حذفه.');
        }

        return true;
    }
}