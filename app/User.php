<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Product;
use App\UuidForKey;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, UuidForKey, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','username','phone','email','status','blocked',
        'avatar','gender','country_id','city_id','verification_status',
        'role','facebook','instagram','google','twitter','last_ip','password',
        'address','bio','last_login','activated_at','blocked_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','last_ip'
    ];

    protected $dateFormat = 'Y-m-d H:i:s.u';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login'=> 'datetime',
        'blocked_at'=>'datetime',
        'activated_at'=>'datetime',
    ];

    public function products()
    {
      return $this->hasMany(Product::class, 'user_id');
    }


      /**
     * The functions for checking roles
     *
     * @var bool
     */

    public function isUser()
    {
      return (Auth::check() && $this->role == 'user');
    }

    public function isAgent()
    {
      return (Auth::check() && $this->role == 'agent');
    }

    public function isAdmin()
    {
      return (Auth::check() && $this->role == 'admin');
    }

    public function isSuperAdmin()
    {
      return (Auth::check() && $this->role == 'super_admin');
    }
}
