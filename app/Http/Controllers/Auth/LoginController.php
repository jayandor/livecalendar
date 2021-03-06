<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login() {
        session([
            'registration_number' => null,
            'completed_forms' => []
        ]);
        return view('auth/login');
    }

    public function logout(Request $request) {
        Auth::logout();
        session([
            'registration_number' => null,
            'completed_forms' => []
        ]);
        return redirect()->route('index');
    }

    public function authenticate(Request $request)
    {
        if ($request->email == '' || $request->password == '') {
            return view('auth/login', ['errors' => [ 'Email and Password are required' ]]);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])) {
            // Authentication passed...
            return redirect()->intended(route('index'));
        } else {
            return view('auth/login', ['errors' => [ 'Login failed' ]]);
        }
    }

}
