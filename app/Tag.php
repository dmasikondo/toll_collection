<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */	
	protected $fillable =[
		'tag_number','is_active', 'vehicle_id',
	];
    public function vehicle()
    {
    	return $this->belongsTo(Vehicle::class);
    }
}
