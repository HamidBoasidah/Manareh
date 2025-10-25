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
        Schema::create('quran_suras', function (Blueprint $table) {
            $table->id();
            $t->unsignedSmallInteger('id')->primary(); // 1..114
            $t->string('name_ar');
            $t->string('name_en')->nullable();
            $t->unsignedSmallInteger('ayah_count');
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
        Schema::dropIfExists('quran_suras');
    }
};
