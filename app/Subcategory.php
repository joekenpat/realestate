<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
  use Sluggable;
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name','slug','category_id'];

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

  public function properties()
  {
    return $this->hasMany(Property::class,  'category_id');
  }
}
