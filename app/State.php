<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name','code','country_iso2'
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
  ];

}
