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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // المستلم الأساسي داخل النظام (صاحب صندوق الوارد)
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // مرونة إضافية (اختياري): إن احتجت تربط الإشعار بكائن آخر بشكل بوليمورفيك
            // مثل student/guardian/... بدون إلزام الواجهة باستخدامه
            $table->string('recipient_type')->nullable(); // student/guardian/...
            $table->unsignedBigInteger('recipient_id')->nullable();

            // قناة الإرسال
            $table->enum('channel', ['inbox', 'sms', 'whatsapp', 'email'])
                ->default('inbox');

            // مرجع للقالب المستخدم (إن وجد)
            $table->foreignId('template_id')
                ->nullable()
                ->constrained('message_templates')
                ->nullOnDelete();

            // نص العنوان والمحتوى النهائي بعد استبدال المتغيرات (ما يُعرض فعلاً للمستخدم)
            $table->string('subject')->nullable();
            $table->text('body')->nullable();

            // بيانات إضافية للربط (IDs، روابط، معلومات...) تستخدمها الواجهة أو التقارير
            $table->json('payload')->nullable();

            // حالة الإشعار:
            // queued = بانتظار الإرسال (مفيد لـ SMS/Email)
            // sent   = تم إنشاؤه/إرساله
            // failed = فشل في قناة خارجية
            $table->string('status', 20)->default('queued');

            // وقت الإرسال الفعلي (لقنوات خارجية أو لتوثيق إنشاء inbox)
            $table->timestamp('sent_at')->nullable();

            // وقت القراءة (Inbox): NULL = غير مقروء
            $table->timestamp('read_at')->nullable();

            // في حال فشل الإرسال لقنوات خارجية
            $table->text('error')->nullable();

            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();

            // فهارس مهمة لصندوق الوارد
            $table->index(['user_id', 'channel', 'status'], 'idx_notifications_user_channel_status');
            $table->index(['user_id', 'channel', 'read_at'], 'idx_notifications_user_read');
            $table->index(['recipient_type', 'recipient_id'], 'idx_notifications_poly_recipient');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
