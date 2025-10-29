<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('enrollments')) {
            return;
        }

        DB::statement(<<<SQL
            CREATE UNIQUE INDEX enrollments_current_guard_unique
            ON enrollments ((CASE WHEN left_at IS NULL THEN student_id ELSE NULL END), deleted_at)
        SQL);

        DB::statement(<<<SQL
            CREATE INDEX enrollments_circle_current_guard_idx
            ON enrollments ((CASE WHEN left_at IS NULL THEN circle_id ELSE NULL END))
        SQL);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('enrollments')) {
            return;
        }

        try {
            DB::statement('DROP INDEX enrollments_current_guard_unique ON enrollments');
        } catch (\Throwable $e) {
            // index already dropped
        }

        try {
            DB::statement('DROP INDEX enrollments_circle_current_guard_idx ON enrollments');
        } catch (\Throwable $e) {
            // index already dropped
        }
    }
};
