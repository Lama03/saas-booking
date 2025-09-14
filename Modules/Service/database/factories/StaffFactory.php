<?php

namespace Modules\Service\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Service\Models\Staff;

class StaffFactory extends Factory
{
    protected $model = Staff::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            // add other staff fields here
        ];
    }
}
