<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
      /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name','category_id'];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ['pivot'];

  protected $dateFormat = 'Y-m-d H:i:s.u';

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [];

  public function properties()
  {
    return $this->belongsToMany(Property::class,  'property_specification','property_id','specification_id');
  }
}
