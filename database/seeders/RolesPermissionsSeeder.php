<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    protected function json(array $value): string
    {
        // JSON بدون ترميز Unicode أو الشرطات المائلة
        return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function run(): void
    {
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        DB::transaction(function () {
            $guard          = config('acl.guard', 'web');

            // الموارد الموافِقة للتعديلات الأخيرة فقط
            $resources      = config('acl.resources', []);
            $resourceLabels = config('acl.resource_labels', []);
            $actionLabels   = config('acl.action_labels', [
                'view'   => ['en' => 'View',   'ar' => 'عرض'],
                'create' => ['en' => 'Create', 'ar' => 'إنشاء'],
                'update' => ['en' => 'Update', 'ar' => 'تعديل'],
                'delete' => ['en' => 'Delete', 'ar' => 'حذف'],
            ]);

            // 1) توليد الأذونات المفردة resource.action فقط
            foreach ($resources as $resource => $actions) {
                $resourceEn = $resourceLabels[$resource]['en']
                    ?? (string) Str::of($resource)->replace('-', ' ')->headline();
                $resourceAr = $resourceLabels[$resource]['ar'] ?? $resource;

                foreach ($actions as $action) {
                    $actEn = $actionLabels[$action]['en'] ?? ucfirst($action);
                    $actAr = $actionLabels[$action]['ar'] ?? $action;

                    DB::table((new Permission)->getTable())->updateOrInsert(
                        ['name' => "{$resource}.{$action}", 'guard_name' => $guard],
                        ['display_name' => $this->json([
                            'en' => "{$actEn} {$resourceEn}",
                            'ar' => "{$actAr} {$resourceAr}",
                        ])]
                    );
                }
            }

            // مُساعد لتجميع أسماء الأذونات
            $permNames = function (array $resList, array $actionsWanted) use ($resources) {
                return collect($resList)->flatMap(function ($res) use ($resources, $actionsWanted) {
                    $allowed = $resources[$res] ?? [];
                    return collect($actionsWanted)
                        ->filter(fn ($a) => in_array($a, $allowed, true))
                        ->map(fn ($a) => "{$res}.{$a}");
                })->values();
            };

            $allActionPerms = collect($resources)
                ->flatMap(fn ($acts, $res) => collect($acts)->map(fn ($a) => "{$res}.{$a}"))
                ->values();

            $allViewPerms = collect($resources)
                ->filter(fn ($acts) => in_array('view', $acts, true))
                ->keys()
                ->map(fn ($res) => "{$res}.view")
                ->values();

            $allNonDeletePerms = $allActionPerms
                ->reject(fn ($name) => Str::endsWith($name, '.delete'))
                ->values();

            // مجموعات منطقية للموارد الحالية
            $geoResources   = ['areas', 'districts', 'governorates'];
            $adminEntities  = ['users', 'roles', 'permissions'];

            // Notifications UI access should be available to everyone so they can
            // view their own notifications. The repository and model scopes
            // must enforce that users only see notifications intended for them.
            $baseAccess = ['dashboard', 'profile', 'notifications'];

            $teachingCore = [
                'circles',
                'students',
                'enrollments',
                'student_attendances',
                'teacher_attendances',
                'nominations',
                'exams',
            ];

            $staffingResources = ['staff_assignments'];

            // precompute teacher permission names so supervisors can reuse them
            $teacherPerms = collect()
                ->merge($permNames($baseAccess, ['view']))
                ->merge($permNames($geoResources, ['view']))
                ->merge($permNames($teachingCore, ['view', 'update']))
                ->merge($permNames(['student_attendances', 'teacher_attendances', 'nominations', 'exams'], ['create']))
                ->unique()
                ->values();

            // Create roles in the canonical order desired by the product owner
            // (1) Super Admin
            $super = Role::updateOrCreate(
                ['name' => 'super-admin', 'guard_name' => $guard],
                ['display_name' => ['en' => 'Super Admin', 'ar' => 'مدير النظام']]
            );
            $super->syncPermissions($allActionPerms->all());

            // (2) Tarbawi Supervisor
            $supervisorTarbawi = Role::updateOrCreate(
                ['name' => 'supervisor_tarbawi', 'guard_name' => $guard],
                ['display_name' => ['en' => 'Tarbawi Supervisor', 'ar' => 'مشرف تربوي']]
            );

            // (3) Educational Supervisor
            $supervisorEdu = Role::updateOrCreate(
                ['name' => 'supervisor_edu', 'guard_name' => $guard],
                ['display_name' => ['en' => 'Educational Supervisor', 'ar' => 'مشرف تعليمي']]
            );

            // (4) Teacher
            $teacher = Role::updateOrCreate(
                ['name' => 'teacher', 'guard_name' => $guard],
                ['display_name' => ['en' => 'Teacher', 'ar' => 'معلم']]
            );
            $teacher->syncPermissions($teacherPerms->all());

            // give supervisors teacher capabilities + staffing management
            $supervisorPerms = collect()
                ->merge($teacherPerms)
                ->merge($permNames($staffingResources, ['view', 'update']))
                ->unique()
                ->values();
            $supervisorEdu->syncPermissions($supervisorPerms->all());
            $supervisorTarbawi->syncPermissions($supervisorPerms->all());

            // (5) Student
            $studentRole = Role::updateOrCreate(
                ['name' => 'student', 'guard_name' => $guard],
                ['display_name' => ['en' => 'Student', 'ar' => 'طالب']]
            );
            $studentResources = array_merge($geoResources, $baseAccess, ['circles', 'enrollments', 'student_attendances', 'nominations', 'exams']);
            $studentPerms = $permNames($studentResources, ['view']);
            $studentRole->syncPermissions($studentPerms->all());

            // Note: 'viewer', 'manager' and 'admin' roles are intentionally omitted
            // so the system uses a minimal canonical role set: super-admin, supervisors,
            // teacher and student. This prevents duplicate role definitions.
        });

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
