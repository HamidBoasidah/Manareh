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
        Schema::create('message_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->string('name');
            $table->string('channel', 50)->default('in_app');
            $table->string('locale', 10)->default(config('app.locale', 'ar'));
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->longText('body');
            $table->json('variables')->nullable();
            $table->json('sample_payload')->nullable();
            $table->json('extras')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['mosque_id', 'code', 'locale', 'channel'], 'message_templates_code_unique');
            $table->index(['channel', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_templates');
    }
};
