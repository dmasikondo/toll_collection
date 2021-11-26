<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tag;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
       // $this->middleware('auth:api');
    }	

    public function index()
    {
    	return Tag::all();
    }
    public function store()
    {
    	/*$this->validate(request(), [
    		'tag_number' => 'required|unique:tags,tag_number|exclude_unless:vehicle_id,null',
    	]);*/
    	//return 'success';
    	//Tag::create(['tag_number' => request()->tag_number]);
    	//return 'success';
    	/*$this->validate(request(), [
			'tag_number' => Rule::unique('tags')->where(function ($query) {
			return $query->where('vehicle_id', !null)->where('tag_number', request()->tag_number);
			})    	
		]);*/
		$this->validate(request(),[
			'tag_number' => 'required|unique:tags,tag_number',				
		]);
		return 'success';    	
    }
}