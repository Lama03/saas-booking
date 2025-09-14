<?php

namespace Modules\Service\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Service\Models\Service;


class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            "tenant_id" => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->words(2, true),
            'category' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'duration' => $this->faker->numberBetween(15, 90),
            'price' => $this->faker->randomFloat(2, 10, 100),
            // tenant_id will be injected in seeder
        ];
    }
}

