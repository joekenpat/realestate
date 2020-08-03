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
    $findable = $request->has('findable') ? $request->findable : false;
    if ($request->has('state')) {
      $state = $request->state;
      if (in_array($state, $state_map)) {
        $item_state =  [$state];
      } else {
        $item_state = $state_map;
      }
    } else {
      $item_state = false;
    }
    if ($request->has('category')) {
      $category = $request->category;
      if (in_array($category, $category_map)) {
        $item_category =  [$category];
      } else {
        $item_category = $category_map;
      }
    } else {
      $item_category = false;
    }

    if ($request->has('subcategory')) {
      $subcategory = $request->subcategory;
      if (in_array($subcategory, $subcategory_map)) {
        $item_subcategory = [$subcategory];
      } else {
        $item_subcategory = $subcategory_map;
      }
    } else {
      $item_subcategory = false;
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

    if ($plan = $request->has('plan')) {
      $plan = $request->plan;
      $item_plan_map = [
        'all',
        'free',
        'distress',
        'featured',
      ];
      if (in_array($plan, $item_plan_map)) {
        if ($plan == 'all') {
          $item_plan = ['free', 'distress', 'featured',];
        } else {
          $item_plan = [$plan];
        }
      } else {
        $item_plan = ['free', 'distress', 'featured',];
      }
    } else {
      $item_plan = false;
    }

    if ($request->has('list_as')) {
      $list_as = $request->list_as;
      $item_list_as_map = [
        'all',
        'rent',
        'sale',
      ];
      if (in_array($list_as, $item_list_as_map)) {
        if ($list_as == 'all') {
          $item_list_as =  [
            'rent',
            'sale',
          ];
        } else {
          $item_list_as =  [$list_as];
        }
      } else {
        $item_list_as =  [
          'rent',
          'sale',
        ];
      }
    } else {
      $item_list_as =  false;
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

    if ($request->has('sort_by')) {
      $sort_by = $request->sort_by;
      $sort_by_map = ["created_at", 'price'];
      if (in_array($sort_by, $sort_by_map)) {
        $item_sort_by =  $sort_by;
      } else {
        $item_sort_by =  $sort_by_map[1];
      }
    } else {
      $item_sort_by = 'created_at';
    }

    if ($request->has('min_price')) {
      $item_min_price = $request->min_price;
    } else {
      $item_min_price = false;
    }

    if ($request->has('max_price')) {
      $item_max_price = $request->max_price;
    } else {
      $item_max_price = false;
    }

    $featured_properties = Property::with([
      'user', 'user.state', 'user.city', 'tags', 'amenities', 'specifications',
      'category', 'subcategory', 'state', 'city',
    ])->withCount(['favourites', 'views'])
      ->where('plan', 'featured')
      ->when($item_state, function ($query) use ($item_state) {
        return $query->whereIn('state_id', $item_state);
      })
      ->when($item_category, function ($query) use ($item_category) {
        return $query->whereIn('category_id', $item_category);
      })
      ->when($item_subcategory, function ($query) use ($item_subcategory) {
        return $query->whereIn('subcategory_id', $item_subcategory);
      })
      ->when($item_status, function ($query) use ($item_status) {
        return $query->whereIn('status', $item_status);
      })
      ->when($item_list_as, function ($query) use ($item_list_as) {
        return $query->whereIn('list_as', $item_list_as);
      })
      ->when($item_min_price, function ($query) use ($item_min_price) {
        return $query->where('price', '>=', $item_min_price);
      })
      ->when($item_max_price, function ($query) use ($item_max_price) {
        return $query->where('price', '<=', $item_max_price);
      })
      ->when($findable, function ($query) use ($findable) {
        return $query->search($findable);
      })
      ->orderBy($item_sort_by, $item_sort_type)
      ->take(8)->get()->append(request()->query());

    $distress_properties = Property::with([
      'user', 'user.state', 'user.city', 'tags', 'amenities', 'specifications',
      'category', 'subcategory', 'state', 'city',
    ])->withCount(['favourites', 'views'])
      ->where('plan', 'distress')
      ->when($item_state, function ($query) use ($item_state) {
        return $query->whereIn('state_id', $item_state);
      })
      ->when($item_category, function ($query) use ($item_category) {
        return $query->whereIn('category_id', $item_category);
      })
      ->when($item_subcategory, function ($query) use ($item_subcategory) {
        return $query->whereIn('subcategory_id', $item_subcategory);
      })
      ->when($item_status, function ($query) use ($item_status) {
        return $query->whereIn('status', $item_status);
      })
      ->when($item_list_as, function ($query) use ($item_list_as) {
        return $query->whereIn('list_as', $item_list_as);
      })
      ->when($item_min_price, function ($query) use ($item_min_price) {
        return $query->where('price', '>=', $item_min_price);
      })
      ->when($item_max_price, function ($query) use ($item_max_price) {
        return $query->where('price', '<=', $item_max_price);
      })
      ->when($findable, function ($query) use ($findable) {
        return $query->search($findable);
      })
      ->orderBy($item_sort_by, $item_sort_type)
      ->take(8)->get()->append(request()->query());
    $site_home_slider = SiteConfig::where('key', 'home_slider')->firstOrFail();
    return view('homepage', ['slider_images' => json_decode($site_home_slider->value), 'featured_properties' => $featured_properties, 'distress_properties' => $distress_properties, 'categories' => $categories, 'states' => $states]);
  }
}
