<?php

namespace Modules\Customer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Customer\Database\Factories\CustomerFactory;

use Modules\Customer\Database\Factories\CustomerFactory; 

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tenant_id',
        'name',
        'email',
        'phone',
        
    ];

    protected static function newFactory(): CustomerFactory
    {
        return CustomerFactory::new();
    }
}
