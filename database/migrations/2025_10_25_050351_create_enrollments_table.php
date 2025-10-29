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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('circle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
        
            // زمن الانضمام والمغادرة لكل فترة
            $table->date('joined_at')->nullable();
            $table->date('left_at')->nullable();
        
            // لتوثيق الأخطاء وإمكانية الرجوع لها
            $table->softDeletes();
            $table->timestamps();
        
            // 🔒 ضمان "ارتباط حالي وحيد" لكل طالب:
            // عمود مولّد يحمل student_id فقط إذا كان left_at NULL
            $table->unsignedBigInteger('current_guard')
                  ->storedAs("IF(left_at IS NULL, student_id, NULL)");
        
            // يمنع أن يكون لطالب واحد أكثر من سجل is_current=TRUE (left_at NULL)
            $table->unique(['current_guard', 'deleted_at']);
        
            // ⚡️ (اختياري) عدّ طلاب الحلقة الحاليين بسرعة:
            // عمود مولّد يحمل circle_id فقط إذا كان left_at NULL
            $table->unsignedBigInteger('circle_current_guard')
                  ->storedAs("IF(left_at IS NULL, circle_id, NULL)");
            $table->index('circle_current_guard');
        
            // ⚡️ فهارس مساعدة للاستعلامات العامة
            $table->index(['student_id']);
            $table->index(['circle_id']);
        
            // (اختياري) منع إدخالات مكررة بنفس اليوم لنفس الحلقة — حسب رغبتك
            // $table->unique(['circle_id','student_id','joined_at','deleted_at']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
