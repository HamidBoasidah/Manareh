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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_type'); // student/guardian/user
            $table->unsignedBigInteger('recipient_id');
            $table->enum('channel', ['inbox','sms','whatsapp','email'])->default('inbox');
            $table->foreignId('template_id')->nullable()->constrained('message_templates')->nullOnDelete();
            $table->json('payload')->nullable(); // {student_id, circle_id, date, status, ...}
            $table->string('status')->default('queued'); // queued/sent/failed
            $table->timestamp('sent_at')->nullable();
            $table->text('error')->nullable();
            $table->timestamps();

            $table->index(['recipient_type','recipient_id','status'], 'idx_notify_recipient');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
