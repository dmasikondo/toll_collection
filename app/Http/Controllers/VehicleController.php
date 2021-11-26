<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;
use App\Owner;
use Auth;

class VehicleController extends Controller
{
    private $encrypted;
    private $regno;

	public function __construct()
	{

		return $this->middleware(['auth'])->except(['registration']);
	}


    public function index()
    {
    	$count=1;
    	$vehicles =Vehicle::with('owner')->paginate(3);
        return view('vehicles.index',compact('vehicles','count'));
    }

    /**
     * Show more details about a registered vehicle 
     *  including decrypted reg no
     */
    public function show(Vehicle $vehicle)
    {
        $encrypted_regno = $vehicle->encryption;
        // Unwrap a string if the distinct boundary exists
        function unwrap($encrypted_regno) {
            $tmp = explode("\xEF\xBB\xBF", $encrypted_regno);
            if(count($tmp) == 1) return false; // If the encrypted_regno doesn't contain the boundary, return false
            return $tmp[1]; // Otherwise, return the unwrapped encrypted_regno
        }

        // Convert binary registration number data into a string
        function bin2str($bin){
            $text = array();
            $bin = explode(' ', $bin);
            for($i=0; count($bin)>$i; $i++)
                $text[] = chr(@bindec($bin[$i]));
            return implode($text);
        }

        // Convert the ones, zeros, and spaces of the hidden binary data to their respective zero-width characters 
        function bin2hidden($str) {
            $str = str_replace(' ', "\xE2\x81\xA0", $str); // Unicode Character 'WORD JOINER' (U+2060) 0xE2 0x81 0xA0
            $str = str_replace('0', "\xE2\x80\x8B", $str); // Unicode Character 'ZERO WIDTH SPACE' (U+200B) 0xE2 0x80 0x8B
            $str = str_replace('1', "\xE2\x80\x8C", $str); // Unicode Character 'ZERO WIDTH NON-JOINER' (U+200C) 0xE2 0x80 0x8C
            return $str;
        }

        $encrypted = $encrypted_regno;
        $unwrap =unwrap($encrypted);
        $decrypted =bin2str($unwrap);
       // $bin2$hidden = bin2hidden($bin2str);

        dd($decrypted);        
    
    }
   

    /**
     * Show form to register a vehicle
     */	
    public function create()
    {
    	return view('vehicles.create');
    }
    public function registration()
    {
    	return view('vehicles.registration');
    }
    public function store()
    {


       
    	$this->validate(request(),[
    		'registration_number' => 'required|unique:vehicles,registration_number',
    		'make' => 'required',
    		'model' => 'required',
    		'year' => 'required',
    		'body_type' => 'required',
    		'color' => 'required|alpha',
    		'net_mass' => 'required|integer|min:100|lt:gross_mass',
    		'gross_mass' => 'required|integer|min:100',
    		'serial_number' => 'required|unique:vehicles,serial_number',
    		'chasis_number' => 'required|unique:vehicles,chasis_number',
    		'engine_capacity' => 'required',
    		'fuel' => 'required',
    		'name' =>'required',
    		'surname' =>'required',
    		'national_id' => 'regex:/^[0-9]{2}+-+[0-9]{6}+[a-z]{1}+[0-9]{2}$/i',
    		'address' => 'required',
    		'city' => 'required',
    		'country'=>'required_with:registered_at|required_with:reg_no',
    		'registered_at' => 'date|before:today|required_with:country|required_with:reg_no',
    		'reg_no' => 'required_with:country|required_with:registered_at',
    		'phone_no' =>'required|digits_between:8,12',
    	]);
    	

        /**
         * store the owner details in the owners table
         */

    	$owner = Owner::create([
    		'surname' => request()->surname,
    		'names' => request()->name,
    		'slug' =>request()->surname.uniqid(),
    		'national_id' => request()->national_id,
    		'phone_no' =>request()->phone_no,
    	]);

        /**
         * encrypt the registration number STENOGRAPHY
         */
        $regno = request('registration_number');

        // make a string to binary conversion of the registration number
          function str2bin($regno){
            $bin = array();
            for($i=0; strlen($regno)>$i; $i++)
                $bin[] = decbin(ord($regno[$i]));
            return implode(' ', $bin);
            }
        // Wrap a string with a distinct boundary
            function wrap($string) {
            return "\xEF\xBB\xBF".$string."\xEF\xBB\xBF"; // Unicode Character 'ZERO WIDTH NON-BREAKING SPACE' (U+FEFF) 0xEF 0xBB 0xBF
            }
        
        $regno2binary = str2bin($regno);
        $encrypted_regno =wrap($regno2binary);
            
    	$vehicle = Auth::user()->vehicles()->create([
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
            'encryption' =>$encrypted_regno,
    		'slug' => uniqid(),   		
    	]);

    /*	$address = $vehicle->addresses()->create([
    		'address' => request()->address,
    		'city' => request()->city,
    	]);*/

    	if(request()->reg_no  !=''){
    		$vehicle->PreviousRegistrations()->create([
    		'country' => request()->country,
    		'reg_no' => request()->reg_no,
    		'registered_at'=>request()->registered_at,
    		]);    		
    	}

    	session()->flash('message',"$vehicle->make $vehicle->registration_number was successfully registered");
    	return redirect('/vehicles');

    }



    public function myEncryption()
    {
        function str2bin($text){
        $bin = array();
        for($i=0; strlen($text)>$i; $i++)
            $bin[] = decbin(ord($text[$i]));
        return implode(' ', $bin);
    }
    function wrap($string) {
        return "\xEF\xBB\xBF".$string."\xEF\xBB\xBF"; // Unicode Character 'ZERO WIDTH NON-BREAKING SPACE' (U+FEFF) 0xEF 0xBB 0xBF
    }
        $text = 'dingani';
        $maboss = str2bin($text);
        $maboss2 =wrap($maboss);
        dd($maboss2);
    }

    public function decrypt()
    {
        // Unwrap a string if the distinct boundary exists
        function unwrap($string) {
            $tmp = explode("\xEF\xBB\xBF", $string);
            if(count($tmp) == 1) return false; // If the string doesn't contain the boundary, return false
            return $tmp[1]; // Otherwise, return the unwrapped string
        }

        // Convert binary data into a string
        function bin2str($bin){
            $text = array();
            $bin = explode(' ', $bin);
            for($i=0; count($bin)>$i; $i++)
                $text[] = chr(@bindec($bin[$i]));
            return implode($text);
        }

        // Convert the ones, zeros, and spaces of the hidden binary data to their respective zero-width characters 
        function bin2hidden($str) {
            $str = str_replace(' ', "\xE2\x81\xA0", $str); // Unicode Character 'WORD JOINER' (U+2060) 0xE2 0x81 0xA0
            $str = str_replace('0', "\xE2\x80\x8B", $str); // Unicode Character 'ZERO WIDTH SPACE' (U+200B) 0xE2 0x80 0x8B
            $str = str_replace('1', "\xE2\x80\x8C", $str); // Unicode Character 'ZERO WIDTH NON-JOINER' (U+200C) 0xE2 0x80 0x8C
            return $str;
        }

        // Convert zero-width characters to hidden binary data
        function hidden2bin($str) {
            $str = str_replace("\xE2\x81\xA0", ' ', $str); // Unicode Character 'WORD JOINER' (U+2060) 0xE2 0x81 0xA0
            $str = str_replace("\xE2\x80\x8B", '0', $str); // Unicode Character 'ZERO WIDTH SPACE' (U+200B) 0xE2 0x80 0x8B
            $str = str_replace("\xE2\x80\x8C", '1', $str); // Unicode Character 'ZERO WIDTH NON-JOINER' (U+200C) 0xE2 0x80
            return $str;
        }

        $encrypted = "﻿1100100 1101001 1101110 1100111 1100001 1101110 1101001﻿";
        $unwrap =unwrap($encrypted);
        $bin2str =bin2str($unwrap);
       // $bin2$hidden = bin2hidden($bin2str);

        dd($bin2str);

    }

}
