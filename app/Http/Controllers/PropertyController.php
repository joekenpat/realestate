<?php

namespace App\Http\Controllers;

use App\Category;
use App\FavouriteProperty;
use App\Notifications\UserViewedProduct;
use App\Property;
use App\PropertyView;
use App\Report;
use App\SiteConfig;
use App\State;
use App\Subcategory;
use App\TransactionRecord;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Unicodeveloper\Paystack\Paystack;

class PropertyController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $categories = Category::select('id', 'name')->get();
    $subcategories = Subcategory::select('id')->get();
    $states = State::select('id')->get();
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
        $item_status = ["active"];
      }
    } else {
      $item_status = false;
    }

    if ($plan = $request->has('plan')) {
      $plan = $request->plan;
      $item_plan_map = [
        'all',
        'free',
        'vip',
        'featured',
        'premium'
      ];
      if (in_array($plan, $item_plan_map)) {
        if ($plan == 'all') {
          $item_plan = [
            'free',
            'vip',
            'featured',
            'premium'
          ];
        } else {
          $item_plan = [$plan];
        }
      } else {
        $item_plan = ['free', 'vip', 'featured', 'premium'];
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

    if ($request->has('result_count')) {
      $result_count =  $request->result_count;
      if (in_array($result_count, [9, 18, 36, 72, 90, 108])) {
        $item_result_count =  $result_count;
      } else {
        $item_result_count =  9;
      }
    } else {
      $item_result_count =  9;
    }

    $properties = Property::with([
      'user', 'user.state', 'user.city', 'tags', 'amenities', 'specifications',
      'category', 'subcategory', 'state', 'city',
    ])->withCount(['favourites', 'views'])
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
      ->when($item_plan, function ($query) use ($item_plan) {
        return $query->whereIn('plan', $item_plan);
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
      ->paginate($item_result_count)->appends(request()->query());
    $min_val = Property::where('status', 'active')->min('price');
    $max_val = Property::where('status', 'active')->max('price');
    $ad_min_val = $min_val ?: 0;
    $ad_max_val = $max_val ?: 999999999;
    return view('property_listing', ['properties' => $properties, 'min_val' => $ad_min_val, 'max_val' => $ad_max_val, 'categories' => $categories, 'init_query' => $request->getQueryString()]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function user_index(Request $request)
  {
    $categories = Category::select('id')->get();
    $subcategories = Subcategory::select('id')->get();
    $states = State::select('id')->get();
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
        $item_status = ["active"];
      }
    } else {
      $item_status = false;
    }

    if ($plan = $request->has('plan')) {
      $plan = $request->plan;
      $item_plan_map = [
        'all',
        'free',
        'vip',
        'featured',
        'premium'
      ];
      if (in_array($plan, $item_plan_map)) {
        if ($plan == 'all') {
          $item_plan = [
            'free',
            'vip',
            'featured',
            'premium'
          ];
        } else {
          $item_plan = [$plan];
        }
      } else {
        $item_plan = [
          'free',
          'vip',
          'featured',
          'premium'
        ];
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

    if ($request->has('result_count')) {
      $result_count =  $request->result_count;
      if (in_array($result_count, [9, 18, 36, 72, 90, 108])) {
        $item_result_count =  $result_count;
      } else {
        $item_result_count =  9;
      }
    } else {
      $item_result_count =  9;
    }

    $properties = Property::with([
      'user:first_name,last_name,username,phone,email,avatar,verification_status',
      'tags:name', 'amenities:name,value', 'specifications:name,value', 'category',
      'subcategory', 'state', 'city'
    ])
      ->where('user_id', Auth::user()->id)
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
      ->when($item_plan, function ($query) use ($item_plan) {
        return $query->whereIn('plan', $item_plan);
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
      ->paginate($item_result_count)->appends(request()->query());
    $min_val = Property::where('status', 'active')->min('price');
    $max_val = Property::where('status', 'active')->max('price');
    $ad_min_val = $min_val ?: 0;
    $ad_max_val = $max_val ?: 999999999;
    return view('property.user_index', ['properties' => $properties, 'min_val' => $ad_min_val, 'max_val' => $ad_max_val]);
  }


  public function user_favourite_property()
  {

    return view('property.favourite');
  }

  public function user_property_view()
  {
    return view('property.property_views');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $categories = Category::with('subcategories')->get();
    $property_plan = SiteConfig::where('key', 'property_plan_fee')->firstOrFail();
    $property_plan_fee = json_decode($property_plan->value);
    return view('property.create', ['categories_data' => $categories, 'plan_fee' => $property_plan_fee]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Property  $property
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, $property_slug)
  {
    $property = Property::with(['user', 'amenities', 'specifications', 'tags', 'user.state', 'user.city', 'state', 'city'])->where('slug', $property_slug)->firstOrFail();
    $viewer_ip = $request->getClientIp();
    if (Auth::check()) {
      $user_id = Auth::user()->id;
      //notify agent of a new view
      // $viewer = User::find(Auth::user()->id);
      // if($property->user->is_agent()){
      // $property->user->notify(new UserViewedProduct($viewer));
      // }
      $fav_status = FavouriteProperty::where('property_id', $property->idg)->where('user_id', Auth()->user()->id)->exists();
    } else {
      $user_id = null;
      $fav_status = false;
    }
    PropertyView::updateOrCreate(
      ['property_id' => $property->id, 'user_id' => $user_id, 'viewer_ip' => $viewer_ip]
    );
    return view('property.view', ['property' => $property, 'fav_status' => $fav_status]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Property  $property
   * @return \Illuminate\Http\Response
   */

  public function edit($property_slug)
  {
    $property = Property::with(['amenities:name,value', 'specifications:name,value', 'tags:name', 'city', 'state'])->where('slug', $property_slug)->firstOrFail();
    $categories = Category::with('subcategories')->get();
    $property_plan = SiteConfig::where('key', 'property_plan_fee')->firstOrFail();
    $property_plan_fee = json_decode($property_plan->value);
    return view('property.edit', ['categories_data' => $categories, 'property' => $property, 'plan_fee' => $property_plan_fee]);
  }

  public function report($property_id)
  {
    $property = Property::with('user')->where('id', $property_id)->firstOrFail();
    return view('report.create', ['property' => $property]);
  }

  public function file_property_report(Request $request, $property_id)
  {
    $this->validate($request, [
      'title' => 'required|string|min:10|max:255|',
      'message' => 'required|string|min:10|max:2000|'
    ]);

    try {
      if (Property::where('id', $property_id)->exists()) {
        $property = Property::where('id', $property_id)->firstOrFail();
        $report = new Report();
        $report->title  = $request->input('title');
        $report->message  = $request->input('message');
        $report->property_id = $property->id;
        $report->user_id = Auth::user()->id;
        $report->save();
        $property->status = 'reported';
        $property->update();
      }

      return redirect()->route('home');
    } catch (Exception $e) {
      return back()->with('error', $e->getMessage());
    }
  }

  /**
   * Obtain Paystack payment information
   * @return void
   */
  public function handleGatewayCallback()
  {
    $paystack = new Paystack();
    $paymentDetails = $paystack->getPaymentData();
    $valid_trx = TransactionRecord::where('transaction_ref', $paymentDetails['data']['reference'])->firstOrFail();
    if ($paymentDetails['data']['status'] === "success") {
      $valid_trx->status =  'success';
      $valid_trx->update();
      $property = Property::where('id', $valid_trx->property_id)->firstOrFail();
      $property_life_span = SiteConfig::where('key', 'property_life_span')->firstOrFail();
      $property_life_span_value = json_decode($property_life_span->value);
      $plan =  $paymentDetails['data']['metadata']['plan'];
      if ($plan == 'vip') {
        $span = $property_life_span_value->vip;
      } elseif ($plan == 'premium') {
        $span = $property_life_span_value->premium;
      } else {
        $span = $property_life_span_value->featured;
      }
      $property->expires_at = now()->addDays($span);
      $property->plan = $plan;
      $property->update();
      return redirect()->route('user_list_property')->with('success', sprintf('Your property: %s is now on %s plan!', $property->title, ucwords($plan)));
    } else {
      return redirect()->route('visit_contest_contestant')->with('error', sprintf('We are unable to upgrade your Property  Ad plan to, some payment error occured'));
    }

    // Now you have the payment details,
    // you can store the authorization_code in your db to allow for recurrent subscriptions
    // you can then redirect or do whatever you want
  }
}
