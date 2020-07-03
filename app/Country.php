<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name','native','iso2',
    'iso3','phone_code','capital',
    'emoji','emojiU','is_allowed',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  protected $dateFormat = 'Y-m-d H:i:s.u';

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'is_allowed'=>'Boolean',
  ];

  public function is_allowed()
  {
    return $this->allowed == true;
  }
}
