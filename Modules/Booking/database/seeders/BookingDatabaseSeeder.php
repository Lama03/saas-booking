<?php

namespace Modules\Booking\Database\Seeders;

use Illuminate\Database\Seeder;

use Modules\Booking\Models\Booking;
use Modules\Tenant\Models\Tenant;

class BookingDatabaseSeeder extends Seeder
{

    public function run(): void
    {
        /**$tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Generate 10 bookings per tenant
            for ($i = 0; $i < 10; $i++) {
                Booking::factory()->create([
                    'tenant_id' => $tenant->id,
                ]);
            }
        } */
    }
}
