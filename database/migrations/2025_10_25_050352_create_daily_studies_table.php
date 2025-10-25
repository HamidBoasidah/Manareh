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
        Schema::create('daily_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('daily_study_sessions')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();

            // الحفظ
            $table->unsignedSmallInteger('hifz_from_sura_id')->nullable();
            $table->unsignedSmallInteger('hifz_from_ayah')->nullable();
            $table->unsignedSmallInteger('hifz_to_sura_id')->nullable();
            $table->unsignedSmallInteger('hifz_to_ayah')->nullable();
            $table->unsignedSmallInteger('hifz_pages')->nullable();

            // المراجعة
            $table->unsignedSmallInteger('murajaah_from_sura_id')->nullable();
            $table->unsignedSmallInteger('murajaah_from_ayah')->nullable();
            $table->unsignedSmallInteger('murajaah_to_sura_id')->nullable();
            $table->unsignedSmallInteger('murajaah_to_ayah')->nullable();
            $table->unsignedSmallInteger('murajaah_pages')->nullable();

            $table->unsignedTinyInteger('points')->default(0); // 0..3
            $table->enum('attendance_status',['present','absent','excused','late_in','early_out'])->default('present');
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['session_id','student_id']);

            // FK للسور
            $table->foreign('mem_from_sura_id')->references('id')->on('quran_suras')->nullOnDelete();
            $table->foreign('mem_to_sura_id')->references('id')->on('quran_suras')->nullOnDelete();
            $table->foreign('rev_from_sura_id')->references('id')->on('quran_suras')->nullOnDelete();
            $table->foreign('rev_to_sura_id')->references('id')->on('quran_suras')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_studies');
    }
};
