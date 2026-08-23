<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <-- هذا هو السطر الذي يحل المشكلة

class User extends Authenticatable
{
    // أضفنا HasApiTokens هنا في البداية
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',      // الحقل الخاص بحالة الحساب
        'last_login_at',  // الحقل الخاص بآخر تسجيل دخول
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',           // تحويل تلقائي لقيمة منطقية
            'last_login_at' => 'datetime',      // تحويل تلقائي لنوع تاريخ ووقت
        ];
    }
}