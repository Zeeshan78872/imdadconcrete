<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    protected function redirectTo()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login');
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ], [
            'username.required' => 'The username field is required.',
            'username.exists' => 'The username that you have entered is incorrect.',
            'password.required' => 'The password field is required.',
        ]);

        $remember = $request->has('remember') ? true : false;
        if (auth()->attempt(array('username' => $input['username'], 'password' => $input['password']), $remember)) {
            if (auth()->check()) {
                // dd(auth());
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->route('login')->withErrors([
                // 'username' => 'The username that you have entered is incorrect.',
                'password' => 'The password that you have entered is incorrect.',
            ])
                ->withInput();
        }
    }
}
