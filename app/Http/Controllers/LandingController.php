<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class LandingController extends Controller
{
    public function welcome(){
    	$plans = Plan::orderBy('id', 'desc')->get();
    	return view('welcome', compact('plans'));
    }

    
}
