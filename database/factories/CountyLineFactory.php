<?php

namespace Database\Factories;

use App\Models\CountyLine;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountyLineFactory extends Factory
{
    protected $model = CountyLine::class;

    public function definition(): array
    {
        return [
            'label' => $this->faker->company() . ' Hotline',
            'number' => $this->faker->phoneNumber(),
            'is_active' => true,
            'sort_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
