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
    Schema::create('working_periods', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->time('from_time');
            $table->time('to_time');
            $table->boolean('is_active')->default(true);
            $table->foreignId('medical_facility_id')->constrained('medical_facilities')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::dropIfExists('working_periods');
    }
};
