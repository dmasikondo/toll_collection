<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Owner;

class OwnerController extends Controller
{
    public function show(Owner $owner)
    {
    	dd($owner);
    	return view('owners.show', compact('owner'));
    }
}
