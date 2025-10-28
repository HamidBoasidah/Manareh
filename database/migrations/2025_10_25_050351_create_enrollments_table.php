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
        
            $table->date('joined_at')->nullable();
            $table->date('left_at')->nullable();
        
            $table->softDeletes();
            $table->timestamps();
        
            // اختياري: لمنع تكرار سجلين لنفس الطالب في نفس الحلقة (تاريخياً)
            $table->unique(['circle_id','student_id','deleted_at']);
        
            // عمود مولَّد يحدد إن كان السجل "حالي"
            // (في MySQL: GENERATED ALWAYS AS ... STORED)
            $table->boolean('is_current')->storedAs("(left_at IS NULL)");
        
            // فهارس للأداء
            $table->index(['student_id','is_current']);
            $table->index(['circle_id','is_current']);
        
            // ضمان عدم وجود أكثر من ارتباط حالي لنفس الطالب
            $table->unique(['student_id','is_current','deleted_at']);
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
