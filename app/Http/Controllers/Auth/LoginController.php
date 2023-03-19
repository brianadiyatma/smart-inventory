<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
        $this->middleware('guest')->except('logout');
    }

    //  protected function credentials()
    // {
    //   if(is_numeric(request('email'))){
    //     return ['nip'=>request('email'),'password'=>request('password')];
    //   }
    //   elseif (filter_var(request('email'), FILTER_VALIDATE_EMAIL)) {
    //     return ['email' => request('email'), 'password'=>request('password')];
    //   }
    //   return ['name' => request('email'), 'password'=>request('password')];
    // }

    public function username(){
      return 'nip';
    }
}
