<?php

namespace Modules\Service\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Modules\Service\Database\Factories\StaffFactory;


class Staff extends Model
{
    //
    use HasFactory;

    protected $fillable = [ 'name'];

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }



    protected static function newFactory()
    {
        return StaffFactory::new(); // 
    }
}
