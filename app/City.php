<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  use Sluggable;
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name','slug','state_code',
  ];

  /**
   * set the attributes to slug from
   *
   * @var String
   */
  public $sluggable = 'name';


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
