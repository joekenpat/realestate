<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UuidForKey;
use App\Sluggable;
use App\Tag;

class Property extends Model
{
  use UuidForKey, Sluggable;
  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;

  /**
   * set the attributes to slug from
   *
   * @var String
   */
  public $sluggable = 'title';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'title', 'slug', 'price', 'images', 'views', 'likes', 'address',
    'user_id', 'category_id', 'subcategory_id', 'phone', 'currency_id',
    'country_id', 'state_id', 'city_id', 'status', 'list_as',
    'plan', 'description', 'expired_at', 'reported_at'
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
    return $this->belongsToMany(Tag::class, 'property_tag', 'property_id', 'tag_id');
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
    return $this->belongsToMany(Specification::class, 'property_specification', 'property_id', 'specification_id')->withPivot('value');
  }
  public function amenities()
  {
    return $this->belongsToMany(Amenity::class, 'amenity_property', 'property_id', 'amenity_id')->withPivot('value');
  }

  public function reports()
  {
    return $this->hasMany(Report::class, 'property_id');
  }

  public function transactions()
  {
    return $this->hasMany(TransactionRecord::class, 'property_id');
  }

  public function is_reported()
  {
    return ($this->status == 'reported' || $this->reported_at != null);
  }

  public function views()
  {
    return $this->hasMany(PropertyView::class, 'property_id');
  }

  public function favourites()
  {
    return $this->hasMany(FavouriteProperty::class, 'property_id');
  }

  public function scopeSearch($query, $findable)
  {
    $findable = preg_replace("/[^A-Za-z0-9_]/", '', $findable);
    $searchValues = preg_split('/\s+/', $findable, -1, PREG_SPLIT_NO_EMPTY);
    return $query
      ->where(function ($query) use ($searchValues) {
        foreach ($searchValues as $value) {
          $query->orWhere('title', 'LIKE', "%{$value}%");
        }
      });
    // ->orWhereHas('city', function ($query) use ($searchValues) {
    //   foreach ($searchValues as $value) {
    //     $query->orWhere('title', 'LIKE', "%{$value}%");
    //   }
    // })
    // ->orWhereHas('state', function ($query) use ($searchValues) {
    //   foreach ($searchValues as $value) {
    //     $query->orWhere('title', 'LIKE', "%{$value}%");
    //   }
    // })
    // ->orWhereHas('amenities', function ($query) use ($searchValues) {
    //   foreach ($searchValues as $value) {
    //     $query->orWhere('title', 'LIKE', "%{$value}%");
    //   }
    // })
    // ->orWhereHas('specifications', function ($query) use ($searchValues) {
    //   foreach ($searchValues as $value) {
    //     $query->orWhere('title', 'LIKE', "%{$value}%");
    //   }
    // })
    // ->orWhereHas('tags', function ($query) use ($searchValues) {
    //   foreach ($searchValues as $value) {
    //     $query->orWhere('title', 'LIKE', "%{$value}%");
    //   }
    // });
  }
}
