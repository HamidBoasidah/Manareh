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
            // link role to roles table instead of storing as enum
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            // keep legacy textual column for compatibility with existing functional indexes
            // and any code that still reads raw DB column. We'll keep it nullable and
            // populate it from the related role when creating records.
            $table->string('role_in_circle')->nullable();
            $table->date('start_at');
            $table->date('end_at')->nullable(); // NULL = مستمر
            $table->text('notes')->nullable();

            $table->unique(['circle_id','user_id','role_id'], 'uniq_circle_user_role');
            $table->index(['user_id','role_id','end_at']);
            $table->index(['circle_id','role_id','end_at']);
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
        Schema::dropIfExists('staff_assignments');
    }
};
