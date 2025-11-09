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
        Schema::create('teacher_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('circle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // المعلّم أو المشرف (الدور يُستخرج من علاقة المستخدم باستخدام Spatie roles)
            $table->date('date_g');
            $table->string('date_h')->nullable();
            $table->enum('status', ['present','absent','excused','late_in','early_out','half_day','on_leave','sick'])->default('present');
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete()->comment('من سجّل الحضور');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();

            // فهارس وقيود لمنع التكرار وتسريع الاستعلامات
            // NOTE: removed 'session' from unique constraint to match current schema
            $table->unique(['circle_id','user_id','date_g'], 'attendance_unique_per_session');
            $table->index(['user_id','date_g'], 'attendance_user_date_idx');
            $table->index(['circle_id','date_g'], 'attendance_circle_date_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_attendances');
    }
};
