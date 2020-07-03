<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'country_iso2', 'country_iso3',
    'code', 'name', 'html_entity',
    'symbol',
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
  protected $casts = [];
}
