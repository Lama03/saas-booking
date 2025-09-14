<?php

namespace Modules\Tenant\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    //protected $model = \Modules\Tenant\Models\TenantFactory::class;

    protected $model = \Modules\Tenant\Models\Tenant::class;

    public function definition(): array
    {
        $name = $this->faker->company;
        return [
            'name' => $name,
            'businessType' => "Fasion",
            'slug' => strtolower(str_replace(' ', '-', $name)) . '.saas.test',
            'logo' => null,
            'color' => $this->faker->safeHexColor,
            'plan' => $this->faker->randomElement(['basic', 'pro', 'enterprise']),
        ];
    }
}

