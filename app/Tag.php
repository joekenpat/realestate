<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
  ];

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

  // declaring tag-product relationship
  public function products()
  {
      return $this->belongsToMany(Product::class, 'product_tag', 'tag_id', 'product_id');
  }

  // // declaring tag-articles relationship
  // public function Articles()
  // {
  //     return $this->belongsToMany(Article::class, 'Article_tag', 'tag_id', 'article_id');
  // }
}
