<?php

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'logo',
        'header_image',
        'primary_color',
        'secondary_color',
        'favicon',
        'page_title',
        'page_description',
        'footer_email',
        'footer_phone',
        'footer_location',
        'footer_av_time',
        'footer_text',
        'booked_today',
        'service_providers',
        'average_booking_time',
    ];

    public function tenant()
    {
        return $this->belongsTo(\Modules\Tenant\Models\Tenant::class);
    }
}
