<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'addressez';	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                'address','city','vehicle_id'
    ];

}
