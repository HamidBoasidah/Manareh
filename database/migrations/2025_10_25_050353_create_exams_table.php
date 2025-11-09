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
            $table->unsignedBigInteger('nomination_id')->nullable();
            $table->foreignId('circle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            // replaced exam_type_id foreign key with an enum since there are only two fixed types
            $table->enum('exam_type', ['stage', 'juzz'])->default('stage');
            $table->date('exam_date_g');
            $table->string('exam_date_h')->nullable();
            $table->unsignedTinyInteger('juzz')->nullable(); // 1..30
            $table->unsignedSmallInteger('total_points')->nullable();
            $table->string('total_grade')->nullable(); // نسبة/حرف
            $table->text('remarks')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();

            $table->index(['student_id','exam_date_g']);
            $table->index(['circle_id','exam_type']);
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
