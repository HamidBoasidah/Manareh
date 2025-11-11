<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('message_templates', function (Blueprint $table) {
            $table->id();

            // NULL = قالب عام على مستوى النظام
            // قيمة = قالب مخصص لمسجد معيّن
            $table->foreignId('mosque_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // كود ثابت يُستخدم من النظام للربط مع الأحداث
            // مثل: STUDENT_ADDED_TO_CIRCLE, EXAM_RESULT_PUBLISHED ...
            $table->string('code');

            // قناة الإرسال (الآن غالباً inbox، لكن جاهز للتوسع)
            $table->enum('channel', ['inbox', 'sms', 'whatsapp', 'email'])
                ->default('inbox');

            // لدعم تعدد اللغات في نفس الكود (ar, en, ...)
            $table->string('locale', 10)->default('ar');

            // عنوان الرسالة داخل الـ Inbox (يمكن يكون NULL لبعض القنوات)
            $table->string('subject')->nullable();

            // نص القالب مع المتغيرات (placeholders)
            $table->text('body');

            $table->text('description')->nullable();

            // تفعيل/تعطيل القالب بدون حذفه
            $table->boolean('is_active')->default(true);

            // لتعليم القوالب الأساسية المزروعة بالـ seeder (اختياري للاستخدام في اللوحة)
            $table->boolean('is_core')->default(false);

            $table->softDeletes();
            $table->timestamps();

            // منع تكرار نفس القالب في نفس النطاق:
            // لكل (mosque_id + code + channel + locale) قالب واحد
            $table->unique(
                ['mosque_id', 'code', 'channel', 'locale'],
                'uq_message_templates_scope'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_templates');
    }
};
