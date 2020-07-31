<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UuidForKey;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Property extends Model
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
    'title', 'price', 'images', 'views', 'likes', 'address',
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

  public function is_reported()
  {
    return ($this->status == 'reported' || $this->reported_at != null);
  }

  public function views_count()
  {
    return DB::table('viewed_property')->where('property_id', $this->id)->count();
  }

  public function favourite_count()
  {
    return DB::table('favourite_property')->where('property_id', $this->id)->count();
  }

  public function scopeFilterByRequest($query, Request $request)
  {
    $query->with('tags:name')
      ->with('amenities:name,value')
      ->with('specifications:name,value')
      ->with('category')
      ->with('subcategory')
      ->with('state')
      ->with('city');
    if ($request->has('category')) {
      $categories = Category::select('id')->get();
      $category_map = [];
      foreach ($categories as $category) {
        $category_map[] = $category->id;
      }
      $category = $request->category;
      $item_category = function () use ($category, $category_map) {
        if (in_array($category, $category_map)) {
          return [$category];
        } else {
          return $category_map;
        }
      };

      $query->whereIn('category_id', $item_category());
    }

    if ($request->has('subcategory')) {
      $subcategories = Subcategory::select('id')->get();
      $subcategory_map = [];
      foreach ($subcategories as $subcategory) {
        $subcategory_map[] = $subcategory->id;
      }
      $subcategory = $request->subcategory;
      $item_subcategory = function () use ($subcategory, $subcategory_map) {
        if (in_array($subcategory, $subcategory_map)) {
          return [$subcategory];
        } else {
          return $subcategory_map;
        }
      };
      $query->whereIn('subcategory_id', $item_subcategory());
    }

    if ($request->has('status')) {
      $status = $request->status;
      $item_status = function () use ($status) {
        $item_status_map = [
          'all',
          'closed',
          'active',
          'pending',
          'reported',
          'expired'
        ];
        if (in_array($status, $item_status_map)) {
          if ($status == 'all') {
            return [
              'closed',
              'active',
              'pending',
              'reported',
              'expired'
            ];
          }
          return [$status];
        } else {
          return ["active"];
        }
      };
      $query->whereIn('status', $item_status());
    }

    if ($plan = $request->has('plan')) {
      $plan = $request->plan;
      $item_plan = function () use ($plan) {
        $item_plan_map = [
          'all',
          'free',
          'distress',
          'featured',
        ];
        if (in_array($plan, $item_plan_map)) {
          if ($plan == 'all') {
            return ['free', 'distress', 'featured',];
          }
          return [$plan];
        } else {
          return ['free', 'distress', 'featured',];
        }
      };
      $query->whereIn('plan', $item_plan());
    }

    if ($request->has('list_as')) {
      $list_as = $request->list_as;
      $item_list_as = function () use ($list_as) {
        $item_list_as_map = [
          'all',
          'rent',
          'sale',
        ];
        if (in_array($list_as, $item_list_as_map)) {
          if ($list_as == 'all') {
            return [
              'rent',
              'sale',
            ];
          }
          return [$list_as];
        } else {
          return [
            'rent',
            'sale',
          ];
        }
      };
      $query->whereIn('list_as', $item_list_as());
    }

    if ($request->has('sort_type') && $request->has('sort_by')) {
      $sort_type =  $request->sort_type;
      $sort_by = $request->sort_by;
      $item_sort_type = function () use ($sort_type) {
        $sort_type_map = ["asc", 'desc'];
        if (in_array($sort_type, $sort_type_map)) {
          return $sort_type;
        } else {
          return $sort_type_map[1];
        }
      };
      $item_sort_by = function () use ($sort_by) {
        $sort_by_map = ["created_at", 'price'];
        if (in_array($sort_by, $sort_by_map)) {
          return $sort_by;
        } else {
          return $sort_by_map[1];
        }
      };
      $query->orderBy($item_sort_by(), $item_sort_type());
    } elseif ($request->has('sort_type')) {
      $sort_type =  $request->sort_type;
      $item_sort_type = function () use ($sort_type) {
        $sort_type_map = ["asc", 'desc'];
        if (in_array($sort_type, $sort_type_map)) {
          return $sort_type;
        } else {
          return $sort_type_map[1];
        }
      };
      $query->orderBy('created_at', $item_sort_type());
    } elseif ($request->has('sort_by')) {
      $sort_by = $request->sort_by;
      $item_sort_by = function () use ($sort_by) {
        $sort_by_map = ["created_at", 'price'];
        if (in_array($sort_by, $sort_by_map)) {
          return $sort_by;
        } else {
          return $sort_by_map[1];
        }
      };
      $query->orderBy($item_sort_by(), 'desc');
    } else {
      $query->orderBy('created_at', 'desc');
    }

    if ($request->has('min_price') && $request->has('max_price')) {
      $item_min_price = $request->min_price;
      $item_max_price = $request->max_price;
      $query->whereBetween('price', [$item_min_price, $item_max_price]);
    } elseif ($request->has('min_price')) {
      $item_min_price = $request->min_price;
      $query->where('price', '>=', $item_min_price);
    } elseif ($request->has('max_price')) {
      $item_max_price = $request->max_price;
      $query->where('price', '<=', $item_max_price);
    } else {
      $item_min_price = Property::where('status', 'active')->min('price');
      $item_max_price = Property::where('status', 'active')->max('price');
      $query->whereBetween('price', [$item_min_price, $item_max_price]);
    }
    return $query;
  }
}
