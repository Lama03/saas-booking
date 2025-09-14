<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;

use Modules\Booking\Models\Booking;
use Modules\Payment\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = Booking::all();

        foreach ($bookings as $booking) {
            Payment::create([
                'booking_id' => $booking->id,
                'payment_status' => 'paid',
                'payment_method' => 'cash',
                'total' => $booking->total ?? 250.00, // fallback if total is not in booking
                'transaction_id' => null,
                'metadata' => json_encode([
                    'note' => 'Test payment seed',
                    'processed_by' => 'Seeder',
                ]),
            ]);
        }
    }
}
