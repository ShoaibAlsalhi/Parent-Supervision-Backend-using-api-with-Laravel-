<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // الحماية تتم عبر الـ Middleware في الـ Routes
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'device_type' => ['required', 'string', 'in:android,ios'],
            'os_version' => ['required', 'string', 'max:50'],
            'battery_level' => ['nullable', 'integer', 'min:0', 'max:100'],
            'storage_space' => ['nullable', 'string', 'max:50'],
            'fcm_token' => ['nullable', 'string'],
        ];
    }
}