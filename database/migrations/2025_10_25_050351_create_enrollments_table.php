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
        Schema::dropIfExists('enrollments');

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
        
            // ⚡️ فهارس مساعدة للاستعلامات العامة
            $table->index('student_id');
            $table->index('circle_id');
        
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
