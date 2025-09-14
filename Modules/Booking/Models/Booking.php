<?php


namespace Modules\Booking\Models;
use Illuminate\Database\Eloquent\Model;

use Modules\Booking\Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Str;

class Booking extends Model
{
    //
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['tenant_id', 'service_id', 'customer_id', 'booked_date', 'booked_time', 'status', 'notes'];


    protected static function newFactory()
    {
        return BookingFactory::new();
    }

    public function tenant()
    {
        return $this->belongsTo(\Modules\Tenant\Models\Tenant::class);
    }

    public function service()
    {
        return $this->belongsTo(\Modules\Service\Models\Service::class);
    }

    public function user()
    {
        return $this->belongsTo(\Modules\User\Models\User::class);
    }

    

    public function customer()
    {
        return $this->belongsTo(\Modules\Customer\Models\Customer::class);
    }

    public function payment()
    {
        return $this->hasOne(\Modules\Payment\Models\Payment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $last = Booking::where('tenant_id', $booking->tenant_id)
                ->latest('id')
                ->first();

            $number = $last
                ? ((int) str_replace('BK-', '', $last->booking_code)) + 1
                : 1001;

            $booking->booking_code = 'BK-' . $number;
        });
    }



}
