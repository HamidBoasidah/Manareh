<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Repositories\StudentRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class StudentService
{
    protected StudentRepository $students;
    protected UserService $users;
    protected ?Role $studentRole = null;

    public function __construct(StudentRepository $students, UserService $users)
    {
        $this->students = $students;
        $this->users = $users;
    }

    public function all(array $with = [])
    {
        return $this->students->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->students->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->students->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $userId = $attributes['user_id'] ?? null;
            $userPayload = Arr::get($attributes, 'user', []);

            if ($userId) {
                if (is_array($userPayload) && ! empty($userPayload)) {
                    $userData = $this->prepareUserPayload($userPayload, false);
                    $this->users->update($userId, $userData);
                }

                $this->ensureStudentRole($userId);
            } else {
                if (! is_array($userPayload) || empty($userPayload)) {
                    throw new RuntimeException('Student creation requires user data when user_id is not provided.');
                }

                $userData = $this->prepareUserPayload($userPayload);
                $user = $this->users->create($userData);
                $userId = $user->id;
                $this->ensureStudentRole($userId);
            }

            $studentData = $this->prepareStudentPayload($attributes);
            $studentData['user_id'] = $userId;

            $student = $this->students->create($studentData);
            $student->loadMissing('user', 'guardian', 'mosque');

            return $student;
        });
    }

    public function update($id, array $attributes)
    {
        return DB::transaction(function () use ($id, $attributes) {
            $student = $this->students->findOrFail($id, ['user']);

            $userPayload = Arr::get($attributes, 'user');
            if (is_array($userPayload) && ! empty($userPayload)) {
                $userData = $this->prepareUserPayload($userPayload, false);
                $this->users->update($student->user_id, $userData);
                $this->ensureStudentRole($student->user_id);
            }

            $studentData = $this->prepareStudentPayload($attributes);

            if (! empty($studentData)) {
                $student = $this->students->update($id, $studentData);
            } else {
                $student->refresh();
            }

            $student->loadMissing('user', 'guardian', 'mosque');

            return $student;
        });
    }

    public function delete($id)
    {
        return $this->students->delete($id);
    }

    public function activate($id)
    {
        return DB::transaction(function () use ($id) {
            $student = $this->students->findOrFail($id, ['user']);

            if (! $student->user_id) {
                throw new RuntimeException('Student activation requires a linked user account.');
            }

            $this->users->activate($student->user_id);

            return $student->load('user');
        });
    }

    public function deactivate($id)
    {
        return DB::transaction(function () use ($id) {
            $student = $this->students->findOrFail($id, ['user']);

            if (! $student->user_id) {
                throw new RuntimeException('Student deactivation requires a linked user account.');
            }

            $this->users->deactivate($student->user_id);

            return $student->load('user');
        });
    }

    /**
     * Prepare the user payload before delegating to the user service.
     */
    protected function prepareUserPayload(array $payload, bool $includeDefaults = true): array
    {
        $data = Arr::only($payload, [
            'name',
            'email',
            'password',
            'address',
            'phone_number',
            'whatsapp_number',
            'is_active',
            'created_by',
            'updated_by',
            'attachment',
        ]);

        if ($includeDefaults && ! array_key_exists('is_active', $data)) {
            $data['is_active'] = true;
        }

        return $data;
    }

    /**
     * Filter the incoming attributes to the allowed student columns.
     */
    protected function prepareStudentPayload(array $attributes): array
    {
        return Arr::only($attributes, [
            'mosque_id',
            'guardian_id',
            'birth_date',
            'nationality',
            'notes',
        ]);
    }

    /**
     * Ensure the linked user always has the student role.
     */
    protected function ensureStudentRole(int $userId): void
    {
        $user = User::findOrFail($userId);
        $role = $this->studentRole();

        if (! $user->hasRole($role->name)) {
            $user->assignRole($role->name);
        }
    }

    protected function studentRole(): Role
    {
        if ($this->studentRole instanceof Role) {
            return $this->studentRole;
        }

        $role = Role::firstWhere('name', 'student');

        if (! $role) {
            throw new RuntimeException('Student role is not defined. Please seed roles before creating students.');
        }

        return $this->studentRole = $role;
    }
}
