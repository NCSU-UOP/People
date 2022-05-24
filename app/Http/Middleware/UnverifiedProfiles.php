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

        //setting up boolean values required for conditions
        if($this->auth->user() != null){
            $auth_user_is_an_admin = $this->auth->user()->usertype == env('ADMIN');
            $auth_user_is_superadmin = User::find($this->auth->user()->id)->admins()->first()->is_admin == 1;
            $auth_user_is_admin_of_the_faculty = User::find($this->auth->user()->id)->admins()->first()->faculty_id == $student->faculty_id;
        }
        else{
            $auth_user_is_an_admin = false;
            $auth_user_is_superadmin = false;
            $auth_user_is_admin_of_the_faculty = false;
        }

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
        elseif(!$auth_user_is_an_admin){
            if($this->auth->user()) {
                if($this->auth->user()->username == $thisUser) {
                    return $next($request);
                }
            }
            abort(404, 'Not Found.');
        }elseif($auth_user_is_superadmin || $auth_user_is_admin_of_the_faculty) {
            return $next($request);
        } 
        //the route cannot be accessed when account is not visible and you are not the owner nor an superadmin/admin of the respective faculty.
        else {
            abort(404, 'Not Found.');
        }

        
    }
}
