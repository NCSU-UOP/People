<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use App\Models\User;

class UnverifiedProfiles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, Closure $next)
    {
        // dd($request->route('username'));
        $thisUser = $request->route('username');

        $student = User::where('username', $thisUser)->firstOrfail()->students()->firstOrfail();

        // if account is visible then account is shown to the public(admins,owner and others) provided the profile is verified. 
        // The respective owner can go to the profile. even if the profile is not verified.
        // the profile will not be shown under peoples when the profile is not verified by admins
        // profile visibility is set to true by default. therefore even the admins need to first verify an account before changing
        // the profile visibility.
        if($student->is_visible == 1){
            if($student->is_verified == 0){
                if($this->auth->user()) {
                    if($this->auth->user()->username == $thisUser) {
                        return $next($request);
                    }
                }
            } else {
                return $next($request);
            }
            abort(404, 'Not Found.');
        }
        //if account is not visible, only respective owner or admins(super admin & admin of the respective faculty) can go to the profile.
        elseif(!($this->auth->user()->admins())){
            if($this->auth->user()->username == $thisUser) {
                return $next($request);
            }
        }elseif($this->auth->user()->admins() && $this->auth->user()->admins()->first() && ($this->auth->user()->admins()->first()->is_admin == 1 || $this->auth->user()->admins()->first()->faculty_id == $student->faculty_id)) {
            return $next($request);
        } 
        //the route cannot be accessed when account is not visible and you are not the owner nor an superadmin/admin of the respective faculty.
        else {
            abort(404, 'Not Found.');
        }

        
    }
}
