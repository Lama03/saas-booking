<?php

namespace Modules\Customer\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Modules\Customer\Models\Customer;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'tenant_id' => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            
        ];
    }
}

