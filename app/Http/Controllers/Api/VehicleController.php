<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Owner;
use App\Vehicle;
use App\Tag;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    public function store()
    {
    	$this->validate(request(),[
    		'registration_number' => 'required|unique:vehicles,registration_number',
    		'make' => 'required',
    		'model' => 'required',
    		'year' => 'required|before:2021|after:1899',
    		'body_type' => 'required',
    		'color' => 'required|alpha',
    		'net_mass' => 'required|integer|min:15|lt:gross_mass',
    		'gross_mass' => 'required|integer|min:20',
    		'serial_number' => 'required|unique:vehicles,serial_number',
    		'chasis_number' => 'required|unique:vehicles,chasis_number',
    		'engine_capacity' => 'required',
    		'fuel' => 'required',
    		'name' =>'required',
    		'surname' =>'required',
    		'national_id' => 'regex:/^[0-9]{2}+-+[0-9]{6}+[a-z]{1}+[0-9]{2}$/i',
    		'address' => 'required',
    		'city' => 'required',
    		'phone_no' =>'required|digits_between:8,12',
    	]);
    if(request()->previousReg == true){
	    	$this->validate(request(),[
	    		'country'=>'required_with:registered_at|required_with:reg_no',
	    		'registered_at' => 'date|before:today|required_with:country|required_with:reg_no',
	    		'reg_no' => 'required_with:country|required_with:registered_at',
	    	]);
    }
    	  
    /*	//dd(Auth::user()->vehicles)->get();
    	$this->validate(request(), [
			'tag_number' => Rule::unique('tags')->where(function ($query) {
			return $query->where('vehicle_id', !null);
			})    	
		]);*/


    	
    	$owner = Owner::create([
    		'surname' => request()->surname,
    		'names' => request()->name,
    		'slug' =>request()->surname.uniqid(),
    		'national_id' => request()->national_id,
    		'phone_no' =>request()->phone_no,
    	]);

    	$vehicle = Vehicle::create([
    		'registration_number' => request()->registration_number,
    		'make' => request()->make,
    		'owner_id' =>$owner->id,
    		'model' => request()->model,
    		'year' => request()->year,
    		'body_type' => request()->body_type,
    		'color' => request()->color,
    		'net_mass' => request()->net_mass,
    		'gross_mass' => request()->gross_mass,
    		'serial_number' => request()->serial_number,
    		'chasis_number' => request()->chasis_number,
    		'engine_capacity' => request()->engine_capacity,
    		'fuel' => request()->fuel, 
    		'slug' => uniqid(),  
    		'registrating_officer' =>auth('api')->user()->id, 		
    	]);

	/*	$check_if_tagNumber_exists = Tag::where('tag_number', request()->tag_number)->where('vehicle_id',null)->first();
		if($check_if_tagNumber_exists){
			$check_if_tagNumber_exists->update(['vehicle_id'=> $vehicle->id, 'is_active' =>true,]);
		}
		else{
			Tag::create([
				'tag_number' => request()->tag_number,
				'vehicle_id' => $vehicle->id,
				'is_active' =>true,
			]);			
		}*/


            Tag::create([
                'tag_number' => request()->tag_number,
                'vehicle_id' => $vehicle->id,
                'is_active' =>true,
            ]); 

    	$address = $vehicle->addresses()->create([
    		'address' => request()->address,
    		'city' => request()->city,
            'chasis_no' =>request()->chasis_number,
    	]);

    	if(request()->reg_no  !=''){
    		$vehicle->PreviousRegistrations()->create([
    		'country' => request()->country,
    		'reg_no' => request()->reg_no,
    		'registered_at'=>request()->registered_at,
    		]);    		
    	}

    	//session()->flash('message',"$vehicle->make $vehicle->registration_number was successfully registered");
    	return 'successful';

    }

}
