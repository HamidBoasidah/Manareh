<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('medical_facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('attachment')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('landline_number')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->foreignId('facility_ownership_id')->constrained('facility_ownerships')->onDelete('cascade');
            $table->foreignId('governorate_id')->constrained('governorates')->onDelete('cascade');
            $table->foreignId('district_id')->constrained('districts')->onDelete('cascade');
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->foreignId('medical_facility_category_id')->constrained('medical_facility_categories')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('medical_facilities')->onDelete('set null');
            $table->boolean('is_general')->default(false);
            $table->foreignId('specialty_id')->nullable()->constrained('specialties')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('medical_facilities');
    }
};
