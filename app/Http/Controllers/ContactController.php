<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use App\Mail\ContactMe;

class ContactController extends Controller
{
    public function show()
    {
    	return view('contact');
    }


    public function store()
    {
    	request()->validate(['email' =>'required|email']);

    /*	\Mail::raw('it works', function($message){
    			$message->to(request()->email)
    			->subject('Hello There');
    	});*/

    	Mail::to(request()->email)
    		->send(new ContactMe());

    	return redirect('/contacts')
    			->with('message','Mail sent');
    }
}
