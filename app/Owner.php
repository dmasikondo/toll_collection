<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                'national_id','surname','names','phone_no','slug',
    ];

    public function vehicles()
    {
    	return $this->hasMany(Vehicle::class, 'owner_id');
    }
}
