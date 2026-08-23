<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    /**
     * السماح بتعبئة جميع الحقول
     * (استخدمنا guarded فارغة لتسهيل العملية بناءً على التحقق الموجود في الـ FormRequest)
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_online' => 'boolean',
            'last_seen_at' => 'datetime',
            'battery_level' => 'integer',
        ];
    }

    /**
     * علاقة الجهاز بالمستخدم (ولي الأمر)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}