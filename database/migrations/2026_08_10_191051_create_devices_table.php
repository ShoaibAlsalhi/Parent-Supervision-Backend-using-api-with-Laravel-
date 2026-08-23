<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('name'); // اسم الجهاز (مثل: هاتف أحمد)
            $table->string('device_type')->default('android'); // نوع الجهاز
            $table->string('os_version')->nullable(); // إصدار النظام
            $table->boolean('is_online')->default(false); // حالة الاتصال
            $table->timestamp('last_seen_at')->nullable(); // وقت آخر اتصال
            $table->tinyInteger('battery_level')->default(100); // نسبة البطارية
            $table->string('storage_space')->nullable(); // مساحة التخزين (مثال: 64GB)
            $table->string('fcm_token')->nullable(); // رمز الإشعارات لدفع التنبيهات
            $table->timestamps();
            
            // Indexing لتحسين سرعة البحث والفلترة عند عرض أجهزة مستخدم معين
            $table->index(['user_id', 'is_online']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};