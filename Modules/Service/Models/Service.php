<?php

namespace Modules\Service\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Service\Database\Factories\ServiceFactory;

use Modules\Service\Models\Staff;


class Service extends Model
{

    use HasFactory;

    protected $fillable = ['tenant_id', 'name', 'duration', 'price', 'category','status','description'];

    public function tenant()
    {
        return $this->belongsTo(\Modules\Tenant\Models\Tenant::class);
    }

    public function bookings()
    {
        return $this->hasMany(\Modules\Booking\Models\Booking::class);
    }

    public function staff()
    {
        return $this->belongsToMany(Staff::class);
    }

    protected static function newFactory()
    {
        return ServiceFactory::new(); // 
    }
}
