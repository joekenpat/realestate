<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
  // protected $redirectTo = RouteServiceProvider::HOME;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  protected function redirectTo()
  {
      return '/user/property';
  }

  protected function authenticated(Request $request, $user)
  {
    $user->update([
      'last_login' => now()->format('Y-m-d H:i:s.u'),
      'last_ip' => $request->getClientIp(),
    ]);
    // Auth::User()->createToken('moni')->accessToken;
  }

  /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
      $messages = [
        'g-recaptcha-response.required' => 'You must check the reCAPTCHA.',
        'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
    ];
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ],$messages);
    }
}
