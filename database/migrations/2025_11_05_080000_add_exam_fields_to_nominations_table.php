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
        Schema::table('nominations', function (Blueprint $table) {
            // exam_type: stage or juzz (nullable to be backward compatible)
            $table->enum('exam_type', ['stage', 'juzz'])->nullable()->after('nomination_type');
            // exam_part: stage number (1..10) or juzz number (1..30)
            $table->unsignedTinyInteger('exam_part')->nullable()->after('exam_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nominations', function (Blueprint $table) {
            $table->dropColumn(['exam_part', 'exam_type']);
        });
    }
};
