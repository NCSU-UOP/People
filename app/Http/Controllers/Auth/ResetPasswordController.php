<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use LdapRecord\Models\ActiveDirectory\User;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->updateAD($user, $password);
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == \Illuminate\Support\Facades\Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, "Password reset sucessfully!")
                    : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            return new JsonResponse(['message' => trans($response)], 200);
        }

        return redirect('/')->with('status', trans($response));
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required', 
                'string', 
                Password::min(8)
                 ->mixedcase()
                 ->numbers()
                 ->symbols(), 
                'max:'.env("USERS_PASSWORD_MAX"), 
                'confirmed'],
        ];
    }

    //update the password of active directory
    protected function updateAD($user, $password)
    {
        $student = $user->students()->first();
        $DN_Level = "CN=".$user->username.", OU=".$student->batch_id.", OU=Undergraduate, OU=Students, OU=".$student->faculty()->firstOrfail()->name.", ".env('LDAP_BASE_DN');            

        try {
            $adUser = User::findOrfail($DN_Level);
            $adUser->unicodepwd=$password;
            $adUser->save();
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
}
