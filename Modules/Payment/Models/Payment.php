<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Payment\Database\Factories\PaymentFactory;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'booking_id',
        'payment_status',   // e.g., 'paid', 'unpaid', 'pending'
        'payment_method',   // e.g., 'cash', 'card', 'paypal'
        'total',           // total payment amount
        'transaction_id',   // external transaction ID if any
        'metadata',         // optional JSON for extra info
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Relationships
     */
    public function booking()
    {
        return $this->belongsTo(\Modules\Booking\Models\Booking::class);
    }

    protected static function newFactory(): PaymentFactory
    {
        return PaymentFactory::new();
    }
}
