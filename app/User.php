<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
    'first_name', 'last_name', 'username', 'phone', 'email', 'status',
    'avatar', 'gender', 'country_id', 'state_id', 'city_id',
    'verification_status', 'role', 'last_ip', 'password', 'address', 'bio',
    'last_login', 'activated_at', 'blocked_at', 'referer'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token', 'last_ip'
  ];

  protected $appends = ['refererUsername'];

  protected $dateFormat = 'Y-m-d H:i:s.u';

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'last_login' => 'datetime',
    'blocked_at' => 'datetime',
    'activated_at' => 'datetime',
  ];

  public function properties()
  {
    return $this->hasMany(Property::class, 'user_id');
  }

  public function getRefererUsernameAttribute()
  {
    if ($this->referer != null) {
      return $this->referer_account->username;
    } else {
      return null;
    }
  }

  public function referer_account()
  {
    return $this->belongsTo(User::class, 'referer');
  }

  public function get_full_name()
  {
    return sprintf("%s %s", $this->last_name, $this->first_name);
  }

  public function articles()
  {
    return $this->hasMany(Article::class, 'user_id');
  }

  public function state()
  {
    return $this->belongsTo(State::class, 'state_id');
  }

  public function city()
  {
    return $this->belongsTo(City::class, 'city_id');
  }

  public function favourite_properties()
  {
    return $this->hasManyThrough(FavouriteProperty::class, Property::class, 'user_id', 'property_id', 'id', 'id');
  }

  public function viewed_properties()
  {
    return $this->hasManyThrough(PropertyView::class, 'user_id');
  }
  /**
   * The functions for checking roles
   *
   * @var bool
   */

  public function is_user()
  {
    return (Auth::check() && $this->role == 'user');
  }

  public function is_agent()
  {
    return (Auth::check() && $this->role == 'agent');
  }

  public function is_admin()
  {
    return (Auth::check() && $this->role == 'admin');
  }

  public function is_super_admin()
  {
    return (Auth::check() && $this->role == 'super_admin');
  }

  public function is_blocked()
  {
    return (Auth::check() && ($this->status == 'blocked' || $this->blocked_at != null));
  }

  public function is_reported()
  {
    return (Auth::check() && ($this->status == 'reported' || $this->blocked_at != null));
  }
}
