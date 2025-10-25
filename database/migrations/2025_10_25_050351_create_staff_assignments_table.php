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
        Schema::create('staff_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('circle_id')->constrained()->cascadeOnDelete();
            $table->enum('role_in_circle', ['teacher','supervisor_edu','supervisor_tarbawi']);
            $table->date('start_at');
            $table->date('end_at')->nullable(); // NULL = مستمر
            $table->text('notes')->nullable();

            $table->unique(['circle_id','user_id','role_in_circle'], 'uniq_circle_user_role');
            $table->index(['user_id','role_in_circle','end_at']);
            $table->index(['circle_id','role_in_circle','end_at']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_assignments');
    }
};
