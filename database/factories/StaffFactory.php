<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    protected $model = Staff::class;

    public function definition(): array
    {
        return [
            'department_id' => Department::factory(),
            'name' => $this->faker->name(),
            'role' => $this->faker->jobTitle(),
            'ext' => (string) $this->faker->numberBetween(100, 999),
            'email' => $this->faker->safeEmail(),
            'office_message' => $this->faker->sentence(),
            'is_senior' => false,
            'sort_order' => $this->faker->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
