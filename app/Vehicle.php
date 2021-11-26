<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                'registration_number','make','slug','model','year','owner_id','body_type','color', 'net_mass','gross_mass','serial_number','chasis_number','engine_capacity','fuel','registrating_officer','encryption',
    ];

    /**
     * A vehicle has many previous registrations
     */
    public function PreviousRegistrations()
    {
    	return $this->hasMany(PreviousRegistration::class, 'vehicle_id');
    }

    /**
     * A vehicle can belong to many addresses
     */

    public function addresses(){
    	return $this->hasMany(Address::class);
    }


    public function owner()
    {
    	return $this->belongsTo(Owner::class);
    }
}
