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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('circle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exam_type_id')->constrained('exam_types')->cascadeOnDelete();
            $table->date('exam_date_g');
            $table->string('exam_date_h')->nullable();
            $table->unsignedTinyInteger('juzz')->nullable(); // 1..30
            $table->unsignedSmallInteger('total_points')->nullable();
            $table->string('total_grade')->nullable(); // نسبة/حرف
            $table->text('remarks')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();

            $table->index(['student_id','exam_date_g']);
            $table->index(['circle_id','exam_type_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
