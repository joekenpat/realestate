<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UuidForKey;
use App\Tag;

class Product extends Model
{
  use UuidForKey;
  /**
  * Indicates if the IDs are auto-incrementing.
  *
  * @var bool
  */
  public $incrementing = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'title','price','images','views','likes','address',
    'user_id','category_id','subcategory_id','phone','currency_id',
    'country_id','state_id','city_id','status','list_as',
    'plan','description','expired_at','reported_at'
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
    'expires_at' => 'datetime',
    'reported_at' => 'datetime',
    'images' => 'Array'
  ];

  // declaring tag model as parent
  public function tags()
  {
      return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id');
  }

  public function user()
  {
      return $this->belongsTo(User::class, 'user_id',);
  }

  public function category()
  {
      return $this->belongsTo(Category::class, 'category_id');
  }

  public function subcategory()
  {
      return $this->belongsTo(Subcategory::class, 'subcategory_id');
  }

  public function state()
  {
      return $this->belongsTo(State::class, 'state_id');
  }

  public function city()
  {
      return $this->belongsTo(City::class, 'city_id');
  }

  public function specifications()
  {
      return $this->belongsToMany(Specification::class, 'product_specification', 'product_id', 'specification_id')->withPivot('value');
  }
  public function amenities()
  {
      return $this->belongsToMany(Amenity::class, 'amenity_product', 'product_id', 'amenity_id')->withPivot('value');
  }

  public function complaint()
  {
      return $this->hasMany(Complaint::class, 'product_id');
  }

  public function is_reported()
  {
      return ($this->status == 'reported' || $this->reported_at != null);
  }
}
