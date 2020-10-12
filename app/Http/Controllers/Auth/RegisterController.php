<?php

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

  use RegistersUsers;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = 'login';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    $messages = [
      'g-recaptcha-response.required' => 'You must check the reCAPTCHA.',
      'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
  ];
    return Validator::make($data, [
      'first_name' => 'required|alpha|max:25|min:2',
      'last_name' => 'required|alpha|max:25|min:2',
      'username' => 'required|alpha_dash|max:25|min:2',
      'email' => 'required|email|max:150|min:5|unique:users,email',
      'c_email' => 'required|email|same:email',
      'referer' => 'sometimes|numeric|digits:11|exists:users,phone',
      'phone' => 'required|numeric|digits:11|unique:users,phone',
      'password' => 'required|string',
      'g-recaptcha-response' => 'required|captcha',
    ], $messages);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
  protected function create(array $data)
  {
    if (array_key_exists('referer', $data)) {
      $referer = User::where('phone', $data['referer'])->first();
      $data['referer'] = $referer->id;
    }
    $data['password'] = Hash::make($data['password']);
    $data['last_ip'] = request()->getClientIp();
    $data['media'] = [];
    $data['last_login'] = now();
    return User::create($data);
  }
}
