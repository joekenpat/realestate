<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name','image'];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ['created_at','updated_at','deleted_at'];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [];

  public function subcategories()
  {
    return $this->hasMany(Subcategory::class,  'category_id');
  }

  public function products()
  {
    return $this->hasManyThrough(Product::class,  Subcategory::class);
  }
}
