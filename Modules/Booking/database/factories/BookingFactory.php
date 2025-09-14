<?php

namespace Modules\Booking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Booking\Models\Booking;
use Modules\Tenant\Models\Tenant;
use Modules\Customer\Models\Customer;
use Modules\Service\Models\Service;


class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
      /**
       *   // First, select a random tenant
        $tenant = Tenant::inRandomOrder()->first();

        // Then select a service that belongs to this tenant
        $service = Service::where('tenant_id', $tenant->id)->inRandomOrder()->first();

        // Optional: pick a customer from the same tenant (if using tenant-based customers)
        $customer = Customer::where('tenant_id', $tenant->id)->inRandomOrder()->first();

        return [
            "tenant_id" => $tenant->id,
            "service_id" => $service->id, // add null safe operator just in case
            "customer_id" => $customer->id,
            'booked_date' => $this->faker->date('Y-m-d'),
            'booked_time' => $this->faker->time('H:i'),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'notes' => $this->faker->sentence(),
        ];
       */
      return [];
    }
}

