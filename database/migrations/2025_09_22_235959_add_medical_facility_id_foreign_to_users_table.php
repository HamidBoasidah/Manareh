<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'medical_facility_id')) {
                $table->foreignId('medical_facility_id')->nullable()->constrained('medical_facilities')->onDelete('cascade');
            } else {
                // إذا كان العمود موجوداً ولكن بدون قيد foreign key
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $doctrineTable = $sm->listTableDetails('users');
                if (!$doctrineTable->hasForeignKey('users_medical_facility_id_foreign')) {
                    $table->dropForeign(['medical_facility_id']);
                    $table->foreign('medical_facility_id')->references('id')->on('medical_facilities')->onDelete('cascade');
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['medical_facility_id']);
        });
    }
};
