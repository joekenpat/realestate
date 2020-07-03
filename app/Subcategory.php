<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
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
  protected $hidden = ['created_at','updated_at','deleted_at'];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [];

  public function category()
  {
    return $this->belongsTo(Category::class,  'category_id');
  }

  public function products()
  {
    return $this->hasMany(Product::class,  'category_id');
  }
}
