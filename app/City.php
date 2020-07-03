<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name','state_code','country_iso2',
    'latitude','longtitude'
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
