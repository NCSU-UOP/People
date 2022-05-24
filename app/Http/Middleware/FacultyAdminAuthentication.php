<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\Admin;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class FacultyAdminAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, Closure $next)
    {
        $usersFacultyCode = null;

        // Get the faulty code of the user/users that the admin is trying to verify 
        if($request->route()->hasParameter('userId')) {
            $user = User::where('id', $request->route()->parameters()['userId'])->firstOrfail();
            
            if($user->usertype == env('STUDENT')) {
                // The user that the admin verifies is a student
                $usersFacultyCode = $user->students()->firstOrfail()->faculty()->firstOrfail()->code;
            } else if($user->usertype == env('ACADEMIC_STAFF')) {
                // The user that the admin verifies is from academic staff
                $usersFacultyCode = $user->academicStaff()->firstOrfail()->faculty()->firstOrfail()->code;
            } else if($user->usertype == env('NON_ACADEMIC_STAFF')) {
                // The user that the admin verifies is from non-academic staff
                $usersFacultyCode = $user->nonAcademicStaff()->firstOrfail()->faculty()->firstOrfail()->code;
            } else {
                // Try to verify an unknown user type
                abort(403, 'Unauthorized action.');
            }
        } else if($request->route()->hasParameter('facultyCode')) {
            $usersFacultyCode = $request->route()->parameters()['facultyCode'];
        }

        // Faculty code of the admin that sent the request
        $adminsFacultyCode = Admin::where('id', $this->auth->user()->id)->firstOrfail()->faculty()->firstOrfail()->code;

        // An admin can verify and get unverified student list of his faculty only
        if($usersFacultyCode != $adminsFacultyCode) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
