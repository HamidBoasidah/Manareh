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
        Schema::create('nominations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('circle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->enum('nomination_type', ['supervisor_nomination', 'ideal_student', 'reader_of_month'])->comment('supervisor_nomination / ideal_student / reader_of_month');
            // Note: nominations do not hold exam_id anymore. Exam will hold nomination_id (one-to-one).
            // status of nomination: submitted / approved / rejected
            $table->enum('status', ['submitted', 'approved', 'rejected'])->default('submitted');
            // link to academic year (optional)
            $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->nullOnDelete();
            $table->foreignId('term_id')->nullable()->constrained('terms')->nullOnDelete();
            $table->foreignId('nominated_by')->constrained('users')->cascadeOnDelete();
            
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nominations');
    }
};
