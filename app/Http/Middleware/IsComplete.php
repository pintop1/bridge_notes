<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Auth::user()->account_type == 'Personal' && (Auth::user()->profile_photo_path == null || Auth::user()->kin == null || Auth::user()->user_data == null)){
            return redirect()->route('profile.show')->with('error_bottom', "<script>$(function(){swal({title: 'You are almost there!', text: 'Please add at lease one bank account to your profile.', icon: 'warning',});});</script>");
        }elseif(Auth::user()->account_type != 'Personal' && (Auth::user()->profile_photo_path == null || Auth::user()->kin == null  || Auth::user()->company == null || Auth::user()->user_data == null)){
            return redirect()->route('profile.show')->with('error_bottom', "<script>$(function(){swal({title: 'You are almost there!', text: 'Please add at lease one bank account to your profile.', icon: 'warning',});});</script>");
        }
        return $next($request);
    }
}
