<?php

namespace App\Http\Controllers;

use App\Category;
use App\Property;
use App\SiteConfig;
use App\State;
use App\Subcategory;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\User  $user_id
   * @return \Illuminate\Http\Response
   */
  public function edit()
  {
    $user = User::with('state:id,code,name')->with('city:id,name')->where('id', Auth()->user()->id)->firstOrFail();
    return view('edit_profile', ['user' => $user]);
  }

  public function homepage(Request $request)
  {
    $sub_cat = Category::with('subcategories')->get();
    $categories = Category::select('id', 'name')->get();
    $subcategories = Subcategory::select('id', 'name')->get();
    $states = State::select('id', 'name')->get();
    $category_map = [];
    $subcategory_map = [];
    $state_map = [];
    foreach ($categories as $category) {
      $category_map[] = $category->id;
    }
    foreach ($subcategories as $subcategory) {
      $subcategory_map[] = $subcategory->id;
    }
    foreach ($states as $state) {
      $state_map[] = $state->id;
    }

    if ($request->has('status')) {
      $status = $request->status;
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
          $item_status  = [
            'closed',
            'active',
            'pending',
            'reported',
            'expired'
          ];
        } else {
          $item_status  = [$status];
        }
      } else {
        $item_status = ['active', 'reported'];
      }
    } else {
      $item_status = ['active', 'reported'];
    }

    if ($request->has('sort_type')) {
      $sort_type =  $request->sort_type;
      $sort_type_map = ["asc", 'desc'];
      if (in_array($sort_type, $sort_type_map)) {
        $item_sort_type =  $sort_type;
      } else {
        $item_sort_type =  $sort_type_map[1];
      }
    } else {
      $item_sort_type = 'asc';
    }


    $featured_properties = Property::with([
      'user', 'user.state', 'user.city', 'tags', 'amenities', 'specifications',
      'category', 'subcategory', 'state', 'city',
    ])->withCount(['favourites', 'views'])
      ->where('plan', 'featured')
      ->when($item_status, function ($query) use ($item_status) {
        return $query->whereIn('status', $item_status);
      })
      ->latest()
      ->take(8)->get()->append(request()->query());

    $recent_properties = Property::with([
      'user', 'user.state', 'user.city', 'tags', 'amenities', 'specifications',
      'category', 'subcategory', 'state', 'city',
    ])->withCount(['favourites', 'views'])
      ->when($item_status, function ($query) use ($item_status) {
        return $query->whereIn('status', $item_status);
      })
      ->latest()
      ->take(8)->get()->append(request()->query());
    $site_home_slider = SiteConfig::where('key', 'home_slider')->firstOrFail();
    return view('homepage', ['sub_cat' => $sub_cat, 'slider_images' => json_decode($site_home_slider->value), 'featured_properties' => $featured_properties, 'recent_properties' => $recent_properties, 'categories' => $categories, 'states' => $states]);
  }

  public function pricing()
  {
    $property_life_span = SiteConfig::where('key', 'property_life_span')->firstOrFail();
    $property_plan_fee = SiteConfig::where('key', 'property_plan_fee')->firstOrFail();
    return view('pricing', [
      'span' => json_decode($property_life_span->value),
      'fee' => json_decode($property_plan_fee->value),
    ]);
  }
}
