<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'category_id'];

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

  public function products()
  {
    return $this->belongsToMany(Product::class,  'amenity_product', 'amenity_id', 'product_id');
  }
}
