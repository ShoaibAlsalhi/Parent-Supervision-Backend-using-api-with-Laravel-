<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser(array $data): array
    {
        $user = $this->userRepository->create($data);
        
        $token = $user->createToken($data['device_name'])->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function loginUser(array $data): array
    {
        $user = $this->userRepository->findByEmail($data['email']);

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['بيانات الدخول غير صحيحة.'],
            ]);
        }

        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['هذا الحساب غير مفعل.'],
            ]);
        }

        // تحديث آخر ظهور
        $user->update(['last_login_at' => now()]);

        // إنشاء التوكن للجهاز الجديد
        $token = $user->createToken($data['device_name'])->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logoutUser($user, string $tokenId = null): void
    {
        if ($tokenId) {
            // تسجيل خروج من جهاز محدد
            $user->tokens()->where('id', $tokenId)->delete();
        } else {
            // تسجيل خروج من الجهاز الحالي
            $user->currentAccessToken()->delete();
        }
    }
}