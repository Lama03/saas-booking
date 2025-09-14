<?php

namespace Database\Seeders;

use Modules\Tenant\Models\Tenant;
use Modules\User\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        User::updateOrCreate(
            ['email' => 'admin@saas.test'],
            [
                'name' => 'Super Admin',
                'phone' => '123456789',

                'email' => 'admin@lama.test',
                'password' => Hash::make('1234'), // 👈 known password
                'role' => 'super_admin', // Optional if you use roles
            ]
        );




        //$this->call(\Modules\Service\Database\Seeders\ServiceDatabaseSeeder::class);
        //$this->call(\Modules\Customer\Database\Seeders\CustomerSeeder::class);
        //$this->call(\Modules\Booking\Database\Seeders\BookingDatabaseSeeder::class);
        $this->call(\Modules\Tenant\Database\Seeders\TenantSeeder::class);
        User::factory(25)->create();


        User::updateOrCreate(
            ['email' => 'admin@saas.test'],
            [

                'tenant_id' => 1,
                'name' => 'Tenant Admin',
                'email' => 'test@t.com',
                'phone' => '123456789',
                'password' => Hash::make('1234'), // 👈 known password
                'role' => 'tenant_admin', // Optional if you use roles
            ]
        );


        $this->call(\Modules\Payment\Database\Seeders\PaymentSeeder::class);

    }
}
