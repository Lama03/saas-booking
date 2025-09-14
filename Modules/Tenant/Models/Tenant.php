<?php

namespace Modules\Tenant\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Database\Factories\TenantFactory;

class Tenant extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'businessType',
        'logo',
        'color',
        'plan',
    ];


    public function services()
    {
        return $this->hasMany(\Modules\Service\Models\Service::class);
    }

    public function bookings()
    {
        return $this->hasMany(\Modules\Booking\Models\Booking::class);
    }



    public function users()
    {
        return $this->hasMany(\Modules\User\Models\User::class);
    }


    public function admin()
    {
        return $this->hasOne(\Modules\User\Models\User::class)->where('role', 'tenant_admin');
    }

    protected static function newFactory()
    {
        return TenantFactory::new(); // 
    }

    public function settings()
    {
        return $this->hasOne(\Modules\Tenant\Models\TenantSetting::class);
    }
}
