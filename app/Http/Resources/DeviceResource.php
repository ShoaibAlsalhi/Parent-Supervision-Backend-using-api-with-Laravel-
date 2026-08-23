<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'device_type' => $this->device_type,
            'os_version' => $this->os_version,
            'is_online' => (bool) $this->is_online,
            'battery_level' => (int) $this->battery_level,
            'storage_space' => $this->storage_space,
            'last_seen_at' => $this->last_seen_at ? $this->last_seen_at->toIso8601String() : null,
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}