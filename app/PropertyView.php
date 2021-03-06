<?php

namespace App;

use App\UuidForKey;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PropertyView extends Model
{

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'property_id', 'user_id', 'viewer_ip',
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


  public function user()
  {
    return $this->belongsTo(User::class, 'user_id',);
  }

  public function property()
  {
    return $this->belongsTo(Property::class, 'property_id');
  }
}
