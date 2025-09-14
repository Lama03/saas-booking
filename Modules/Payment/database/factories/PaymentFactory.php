<?php

namespace Modules\Payment\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Payment\Models\Payment;

use Modules\Booking\Models\Booking;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(), // or an existing booking ID if seeding with real data
            'payment_status' => $this->faker->randomElement(['paid', 'unpaid', 'pending']),
            'payment_method' => $this->faker->randomElement(['Cash', 'Card', 'Paypal', 'Bank Transfer']),
            'total' => $this->faker->randomFloat(2, 50, 500),
            'transaction_id' => $this->faker->unique()->uuid,
            'metadata' => [
                'note' => $this->faker->sentence(),
                'payer' => $this->faker->name(),
            ],
        ];
    }
}

