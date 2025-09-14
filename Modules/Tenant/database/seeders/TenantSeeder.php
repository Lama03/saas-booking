<?php

namespace Modules\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Booking\Models\Booking;
use Modules\Tenant\Models\Tenant;
use Modules\Customer\Models\Customer;
use Modules\Service\Models\Service;
use Modules\Service\Models\Staff;



use Faker\Factory as Faker;


class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();


        Tenant::create(
            [
                'name' => 'Tenant Admin',
                'slug' => 'spa-zone',
                'businessType' => 'Saloon',
                'logo' => '',
                'color' => 'green',

            ]
        );

        $services = Service::factory(5)->create(['tenant_id' => 1]);
        $customers = Customer::factory(10)->create(['tenant_id' => 1]);

        if ($services->isEmpty() || $customers->isEmpty()) {
            return;
        }

        $services->each(function ($service) {
            // Create example staff members (or use existing ones)
            $staffMembers = Staff::factory(3)->create(); // Create 3 staff for this service

            // Attach them to the service
            $service->staff()->attach($staffMembers->pluck('id'));
        });

        foreach (range(1, end: 15) as $i) {
            Booking::create([
                'tenant_id' => 1,
                'service_id' => $services->random()->id,
                'customer_id' => $customers->random()->id,
                'booked_date' => $faker->date('Y-m-d'),
                'booked_time' => $faker->time('H:i'),
                'status' => $faker->randomElement(['pending', 'confirmed', 'cancelled']),
                'notes' => $faker->sentence(),
            ]);
        }



        Tenant::factory(10)->create()->each(function ($tenant) use ($faker) {

            $services = Service::factory(5)->create(['tenant_id' => $tenant->id]);
            $customers = Customer::factory(10)->create(['tenant_id' => $tenant->id]);

            if ($services->isEmpty() || $customers->isEmpty()) {
                return;
            }

            foreach (range(1, end: 50) as $i) {
                Booking::create([
                    'tenant_id' => $tenant->id,
                    'service_id' => $services->random()->id,
                    'customer_id' => $customers->random()->id,
                    'booked_date' => $faker->date('Y-m-d'),
                    'booked_time' => $faker->time('H:i'),
                    'status' => $faker->randomElement(['pending', 'confirmed', 'cancelled']),
                    'notes' => $faker->sentence(),
                ]);
            }
        });




    }
}
