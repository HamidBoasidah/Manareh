<?php

namespace Database\Factories;

use App\Models\StaffAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffAssignmentFactory extends Factory
{
    protected $model = StaffAssignment::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');

        // prefer staff-specific roles; fallback to any existing role or create one
        // we also populate legacy `role_in_circle` textual column for compatibility
        // with the functional indexes and older code paths.
        $role = \App\Models\Role::whereIn('name', ['teacher','supervisor_edu','supervisor_tarbawi'])->inRandomOrder()->first()
            ?? \App\Models\Role::inRandomOrder()->first()
            ?? \App\Models\Role::factory()->create();

        return [
            'role_id' => $role->id,
            'role_in_circle' => $role->name,
            'start_at' => $this->faker->date(),
            'end_at' => null,
            'notes' => $ar->sentence(),
        ];
    }
}
