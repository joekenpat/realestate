<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UuidForKey;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Report extends Model
{

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'title', 'property_id', 'user_id', 'status', 'message',
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
  protected $casts = [];


  public function reporter()
  {
    return $this->belongsTo(User::class, 'user_id',);
  }

  public function property()
  {
    return $this->belongsTo(Property::class, 'property_id');
  }

  public function property_owner()
  {
    return $this->hasOneThrough(User::class, Property::class);
  }

  public function city()
  {
    return $this->belongsTo(City::class, 'city_id');
  }
}
