<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  use Sluggable;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name','slug',
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
  protected $hidden = ['pivot'];
  protected $dateFormat = 'Y-m-d H:i:s.u';
  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
  ];

  // declaring tag-Property relationship
  public function properties()
  {
      return $this->belongsToMany(Property::class, 'property_tag', 'tag_id', 'property_id');
  }

  // // declaring tag-articles relationship
  // public function Articles()
  // {
  //     return $this->belongsToMany(Article::class, 'Article_tag', 'tag_id', 'article_id');
  // }
}
