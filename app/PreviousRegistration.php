<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreviousRegistration extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'previous_registrations';	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                'country', 'reg_no', 'zimbabwe_registration_at','registered_at',
    ];

    protected $casts = [
        'zimbabwe_registered_at' => 'datetime',
        'registered_at' => 'datetime',
    ];    

}
