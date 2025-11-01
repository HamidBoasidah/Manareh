<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('staff_assignments')) {
            return;
        }

        // (1) منع أكثر من تعيين مفتوح للمعلم
        DB::statement(<<<SQL
            CREATE UNIQUE INDEX staff_teacher_one_open_unique
            ON staff_assignments ((
                CASE
                    WHEN role_in_circle = 'teacher'
                     AND is_active = 1
                     AND end_at IS NULL
                     AND deleted_at IS NULL
                    THEN user_id ELSE NULL
                END
            ))
        SQL);

        // (2) منع تكرار تعيين مفتوح لنفس الحلقة للمشرف
        DB::statement(<<<SQL
            CREATE UNIQUE INDEX staff_supervisor_open_per_circle_unique
            ON staff_assignments (
                (
                    CASE
                        WHEN role_in_circle IN ('supervisor_edu','supervisor_tarbawi')
                         AND is_active = 1
                         AND end_at IS NULL
                         AND deleted_at IS NULL
                        THEN role_in_circle ELSE NULL
                    END
                ),
                (
                    CASE
                        WHEN role_in_circle IN ('supervisor_edu','supervisor_tarbawi')
                         AND is_active = 1
                         AND end_at IS NULL
                         AND deleted_at IS NULL
                        THEN circle_id ELSE NULL
                    END
                ),
                (
                    CASE
                        WHEN role_in_circle IN ('supervisor_edu','supervisor_tarbawi')
                         AND is_active = 1
                         AND end_at IS NULL
                         AND deleted_at IS NULL
                        THEN user_id ELSE NULL
                    END
                )
            )
        SQL);
    }

    public function down(): void
    {
        if (! Schema::hasTable('staff_assignments')) {
            return;
        }

        try { DB::statement("DROP INDEX staff_teacher_one_open_unique ON staff_assignments"); } catch (\Throwable $e) {}
        try { DB::statement("DROP INDEX staff_supervisor_open_per_circle_unique ON staff_assignments"); } catch (\Throwable $e) {}
    }
};