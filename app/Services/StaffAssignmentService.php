<?php

namespace App\Services;

use App\Repositories\StaffAssignmentRepository;
use App\Models\Circle;
use App\Models\User;
use App\Models\Role;
use App\Models\StaffAssignment;
use Illuminate\Validation\ValidationException;
class StaffAssignmentService
{
    protected StaffAssignmentRepository $assignments;

    public function __construct(StaffAssignmentRepository $assignments)
    {
        $this->assignments = $assignments;
    }

    public function all(array $with = [])
    {
        return $this->assignments->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->assignments->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->assignments->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        // If frontend provided role_in_circle (slug) but not role_id, resolve it to the DB id
        if (empty($attributes['role_id']) && !empty($attributes['role_in_circle'])) {
            $role = Role::where('name', $attributes['role_in_circle'])->first();
            if ($role) {
                $attributes['role_id'] = $role->id;
            }
        }

        // Keep is_active consistent with end_at: if end_at is set, mark inactive
        if (array_key_exists('end_at', $attributes)) {
            $attributes['is_active'] = empty($attributes['end_at']) ? ($attributes['is_active'] ?? true) : false;
        }

        // Server-side guard: prevent more than one active assignment for the same circle & role
        // Determine role name (prefer role_in_circle slug, fallback to role relation)
        $roleName = $attributes['role_in_circle'] ?? null;
        if (empty($roleName) && !empty($attributes['role_id'])) {
            $r = Role::find($attributes['role_id']);
            $roleName = $r?->name ?? null;
        }

        // Consider this an "open/active" assignment if is_active true and end_at is null/empty
        $isOpen = (!array_key_exists('is_active', $attributes) || (bool)$attributes['is_active']) && (empty($attributes['end_at']));

        if ($isOpen && $roleName && !empty($attributes['circle_id'])) {
            $exists = StaffAssignment::query()
                ->where('circle_id', $attributes['circle_id'])
                ->where(function ($q) use ($roleName) {
                    $q->where('role_in_circle', $roleName)
                      ->orWhereHas('role', function ($qr) use ($roleName) {
                          $qr->where('name', $roleName);
                      });
                })
                ->where('is_active', 1)
                ->whereNull('end_at')
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'circle_id' => [trans('staff_assignments.roleAlreadyAssigned') ?: 'An active assignment already exists for this role in the selected circle.']
                ]);
            }
        }

        return $this->assignments->create($attributes);
    }

    public function update($id, array $attributes)
    {
        // Resolve role_id from role_in_circle if not provided
        if (empty($attributes['role_id']) && !empty($attributes['role_in_circle'])) {
            $role = Role::where('name', $attributes['role_in_circle'])->first();
            if ($role) {
                $attributes['role_id'] = $role->id;
            }
        }

        // Sync is_active with end_at when present
        if (array_key_exists('end_at', $attributes)) {
            $attributes['is_active'] = empty($attributes['end_at']) ? ($attributes['is_active'] ?? true) : false;
        }

        // Prevent updating an assignment that would result in multiple active assignments for the same circle & role
        $roleName = $attributes['role_in_circle'] ?? null;
        if (empty($roleName) && !empty($attributes['role_id'])) {
            $r = Role::find($attributes['role_id']);
            $roleName = $r?->name ?? null;
        }

        $isOpen = array_key_exists('is_active', $attributes) ? (bool)$attributes['is_active'] : true;
        $isEndAtEmpty = !array_key_exists('end_at', $attributes) || empty($attributes['end_at']);

        if ($isOpen && $isEndAtEmpty && $roleName && !empty($attributes['circle_id'])) {
            $exists = StaffAssignment::query()
                ->where('circle_id', $attributes['circle_id'])
                ->where(function ($q) use ($roleName) {
                    $q->where('role_in_circle', $roleName)
                      ->orWhereHas('role', function ($qr) use ($roleName) {
                          $qr->where('name', $roleName);
                      });
                })
                ->where('is_active', 1)
                ->whereNull('end_at')
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'circle_id' => [trans('staff_assignments.roleAlreadyAssigned') ?: 'An active assignment already exists for this role in the selected circle.']
                ]);
            }
        }

        return $this->assignments->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->assignments->delete($id);
    }

    public function activate($id)
    {
        return $this->assignments->activate($id);
    }

    public function deactivate($id)
    {
        return $this->assignments->deactivate($id);
    }

    /**
     * Prepare data used by the Create page for staff assignments.
     * Returns an array with keys: circles, users, roles, existingAssignments
     */
    public function prepareCreateData(array $staffRoleNames = null): array
    {
        $circles = Circle::select('id', 'name')->orderBy('name')->get();

        // only staff roles we care about (slugs)
        if ($staffRoleNames === null) {
            $staffRoleNames = [
                'teacher',
                'supervisor_edu',
                'supervisor_tarbawi',
            ];
        }

        // return only users that have one of the staff roles
        $users = User::whereHas('roles', function ($q) use ($staffRoleNames) {
            $q->whereIn('name', $staffRoleNames);
        })->select('id', 'name')->orderBy('name')->get();

        // return only the role info for those staff roles and shape for frontend
        $roles = Role::whereIn('name', $staffRoleNames)
            ->orderBy('name')
            ->get()
            ->map(function ($r) {
                return [
                    'id' => $r->id,
                    'value' => $r->name, // slug
                    'label' => $r->display_name ?? $r->name,
                ];
            });

        // prepare existing assignments for frontend: for each circle return two rows
        // - teacher assignment
        // - supervisor assignment (prefers any supervisor role present)
        $teacherAssignments = StaffAssignment::with(['user:id,name','role:id,name'])
            ->whereHas('role', function ($q) {
                $q->where('name', 'teacher');
            })
            ->where('is_active', 1)
            ->whereNull('end_at')
            ->get()
            ->keyBy('circle_id');

        $supervisorAssignments = StaffAssignment::with(['user:id,name','role:id,name'])
            ->whereHas('role', function ($q) {
                $q->whereIn('name', ['supervisor_edu', 'supervisor_tarbawi']);
            })
            ->where('is_active', 1)
            ->whereNull('end_at')
            ->get()
            ->keyBy('circle_id');

        $existingAssignments = [];
        foreach ($circles as $c) {
            // teacher row
            $t = $teacherAssignments->get($c->id);
            $existingAssignments[] = [
                'circle_id' => $c->id,
                'role_in_circle' => 'teacher',
                'user_name' => $t?->user?->name ?? null,
                'is_active' => $t?->is_active ? (bool)$t->is_active : false,
            ];

            // supervisor row (prefer supervisor_edu if both exist, otherwise any)
            $s = $supervisorAssignments->get($c->id);
            $existingAssignments[] = [
                'circle_id' => $c->id,
                'role_in_circle' => $s?->role?->name ?? 'supervisor_edu',
                'user_name' => $s?->user?->name ?? null,
                'is_active' => $s?->is_active ? (bool)$s->is_active : false,
            ];
        }

        return [
            'circles' => $circles,
            'users' => $users,
            'roles' => $roles,
            'existingAssignments' => $existingAssignments,
        ];
    }

    /**
     * Unassign (end) the active assignment for a given circle and role name.
     * Sets end_at to today (date only, at 00:00:00) and sets is_active = false.
     * Returns the updated StaffAssignment model or null if none found.
     *
     * @param int $circleId
     * @param string $roleName
     * @return \App\Models\StaffAssignment|null
     */
    public function unassignByCircleAndRole(int $circleId, string $roleName)
    {
        $q = StaffAssignment::query()->where('circle_id', $circleId)
            ->whereNull('end_at')
            ->where('is_active', 1);

        // try matching by relation role name or legacy role_in_circle
        $assignment = (clone $q)->whereHas('role', function ($qr) use ($roleName) {
            $qr->where('name', $roleName);
        })->first();

        if (! $assignment) {
            $assignment = $q->where('role_in_circle', $roleName)->first();
        }

        if (! $assignment) {
            return null;
        }

    // store date only (YYYY-MM-DD) — DB column is DATE
        $assignment->end_at = \Carbon\Carbon::now()->toDateString();
        $assignment->is_active = false;
        $assignment->save();

        return $assignment;
    }
}
