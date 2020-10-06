<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Property;
use App\Report;
use App\SiteConfig;
use App\Subcategory;
use App\TransactionRecord;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
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
    $min_val = Property::where('status', 'active')->min('price');
    $max_val = Property::where('status', 'active')->max('price');
    $ad_min_val = $min_val ?: 0;
    $ad_max_val = $max_val ?: 999999999;
    return view('home', ['min_val' => $ad_min_val, 'max_val' => $ad_max_val]);
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

  public function homepage()
  {
    return view('homepage');
  }

  public function overview()
  {
    $pcounts = DB::table('properties')->selectRaw("DATE_FORMAT(created_at, '%H') as hour, count(id) as number")
      ->where('created_at', '>=', now()->subHours(24))
      ->groupBy('hour')
      ->get()->toArray();
    // return dd($counts);
    $plabels = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',];
    $pdata = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,];
    foreach ($pcounts as $key =>  $count) {
      $plabels[$key] = $count->hour;
      $pdata[$key] = $count->number;
    }
    $tcounts = DB::table('transaction_records')->selectRaw("DATE_FORMAT(created_at, '%H') as hour, count(id) as number")
      ->where('created_at', '>=', now()->subHours(24))
      ->where('status', 'success')
      ->groupBy('hour')
      ->get()->toArray();
    // return dd($counts);
    $tlabels = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',];
    $tdata = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,];
    foreach ($tcounts as $key =>  $count) {
      $tlabels[$key] = $count->hour;
      $tdata[$key] = $count->number;
    }
    $ucounts = DB::table('users')->selectRaw("DATE_FORMAT(created_at, '%H') as hour, count(id) as number")
      ->where('created_at', '>=', now()->subHours(24))
      ->groupBy('hour')
      ->get()->toArray();
    // return dd($counts);
    $ulabels = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',];
    $udata = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,];
    foreach ($ucounts as $key =>  $count) {
      $ulabels[$key] = $count->hour;
      $udata[$key] = $count->number;
    }
    $pdata = [
      "labels" => $plabels,
      "datasets" => [[
        "label" => 'No of Properties',
        "data" => $pdata,
        "backgroundColor" => 'rgba(255, 159, 64,0.6)',
        "borderColor" => 'rgb(255, 159, 64)',
        "pointRadius" => 0,
        "borderWidth" => 2,
        "barPercentage" => 0.9,
        "categoryPercentage" => 1.0,
      ]]
    ];
    $tdata = [
      "labels" => $tlabels,
      "datasets" => [[
        "label" => 'No of Transaction',
        "data" => $tdata,
        "backgroundColor" => 'rgba(255, 159, 64,0.6)',
        "borderColor" => 'rgb(255, 159, 64)',
        "pointRadius" => 0,
        "borderWidth" => 2,
        "barPercentage" => 0.9,
        "categoryPercentage" => 1.0,
      ]]
    ];
    $udata = [
      "labels" => $ulabels,
      "datasets" => [[
        "label" => 'No of Users',
        "data" => $udata,
        "backgroundColor" => 'rgba(255, 159, 64,0.6)',
        "borderColor" => 'rgb(255, 159, 64)',
        "pointRadius" => 0,
        "borderWidth" => 2,
        "barPercentage" => 0.9,
        "categoryPercentage" => 1.0,
      ]]
    ];
    $options = [
      "responsive" => true,
      "maintainAspectRation" => false,
      "legend" => ["display" => false],
      "scales" => [
        "xAxes" => [["gridLines" => ["display" => false], "ticks" => ["display" => false]]],
        "yAxes" => [["gridLines" => ["display" => false], "ticks" => ["display" => false]]],
      ],
      "layout" => [
        "padding" => [
          "left" => -10,
          "right" => -4,
          "top" => 0,
          "bottom" => -10
        ]
      ],

    ];
    $total_properties = Property::count();
    $total_users = User::count();
    $total_transactions = TransactionRecord::where('status', 'success')->count();
    $total_posts = Post::count();
    $lastest_properties = Property::latest()->take(5)->get();
    $lastest_users = User::latest()->take(5)->get();
    return view('admin.overview', ['total_users' => $total_users, 'total_transactions' => $total_transactions, 'total_posts' => $total_posts, 'total_properties' => $total_properties, 'pdata' => $pdata, 'tdata' => $tdata, 'udata' => $udata, 'options' => $options, 'latest_properties' => $lastest_properties, 'latest_users' => $lastest_users]);
  }

  public function media_settings()
  {
    $site_logo = SiteConfig::where('key', 'logo')->firstOrFail();
    $site_home_slider = SiteConfig::where('key', 'home_slider')->firstOrFail();
    return view('admin.media_settings', ['logo' => $site_logo->value, "home_slider" => json_decode($site_home_slider->value)]);
  }

  public function payment_settings()
  {
    $paystack_keys = SiteConfig::where('key', 'paystack_keys')->firstOrFail();
    return view('admin.payment_settings', ['paystack_keys' => json_decode($paystack_keys->value)]);
  }

  public function update_payment_settings(Request $request)
  {
    $this->validate($request, [
      'public_key' => 'nullable|alpha_dash|max:55',
      'secret_key' => 'nullable|alpha_dash|max:55'
    ]);
    $paystack_keys = SiteConfig::where('key', 'paystack_keys')->firstOrFail();
    $keys = json_decode($paystack_keys->value);
    $keys->secret = $request->input('secret_key');
    $keys->public = $request->input('public_key');
    $paystack_keys->value = json_encode($keys);
    $paystack_keys->update();
    return back()->with('success', 'API keys Updated');
  }

  public function property_settings()
  {
    $property_max_media = SiteConfig::where('key', 'property_max_media')->firstOrFail();
    $property_life_span = SiteConfig::where('key', 'property_life_span')->firstOrFail();
    $property_plan_fee = SiteConfig::where('key', 'property_plan_fee')->firstOrFail();
    return view('admin.property_settings', [
      'max_media' => $property_max_media->value,
      'span' => json_decode($property_life_span->value),
      'fee' => json_decode($property_plan_fee->value),
    ]);
  }


  public function update_property_settings(Request $request)
  {
    $this->validate($request, [
      'free_span' => 'required|numeric|',
      'vip_span' => 'required|numeric|',
      'premium_span' => 'required|numeric|',
      'featured_span' => 'required|numeric|',
      'vip_price' => 'required|numeric|',
      'premium_price' => 'required|numeric|',
      'featured_price' => 'required|numeric|',
      'max_media' => 'required|numeric|',
    ]);
    try {
      $property_max_media = SiteConfig::where('key', 'property_max_media')->firstOrFail();
      $property_life_span = SiteConfig::where('key', 'property_life_span')->firstOrFail();
      $property_plan_fee = SiteConfig::where('key', 'property_plan_fee')->firstOrFail();
      $span = json_decode($property_life_span->value);
      $fee = json_decode($property_plan_fee->value);
      $span->free = $request->input('free_span');
      $span->vip = $request->input('vip_span');
      $span->premium = $request->input('premium_span');
      $span->featured = $request->input('featured_span');
      $fee->vip = $request->input('vip_price');
      $fee->premium = $request->input('premium_price');
      $fee->featured = $request->input('featured_price');
      $property_max_media->value = $request->input('max_media');
      $property_life_span->value = json_encode($span);
      $property_plan_fee->value = json_encode($fee);
      $property_max_media->update();
      $property_life_span->update();
      $property_plan_fee->update();
      return back()->with('success', 'Ad Configurations Updated');
    } catch (Exception $e) {
      return dd($e);
    }
  }


  public function store_home_slider_image(Request $request)
  {
    $this->validate($request, [
      'slider' => 'required',
      'slider.*' => 'image|mimes:jpg,png,jpeg,gif|max:2048'
    ]);
    $site_home_slider = SiteConfig::where('key', 'home_slider')->firstOrFail();
    $slider_links = json_decode($site_home_slider->value);
    $slider_images = $request->file('slider');
    foreach ($slider_images as $image) {
      $path = public_path("images/misc");
      $image_ext = $image->getClientOriginalExtension();
      $image_name = sprintf("slider_%s.%s", bin2hex(random_bytes(15)), $image_ext);
      $image->move($path, $image_name);
      $slider_links[] = $image_name;
    }
    $site_home_slider->value = json_encode($slider_links);
    $site_home_slider->update();
    return back()->with('success', 'slider images uploaded');
  }

  public function delete_home_slider_image($image_name)
  {
    $site_home_slider = SiteConfig::where('key', 'home_slider')->firstOrFail();
    $slider_links = json_decode($site_home_slider->value);
    if (File::exists(public_path("images/misc/" . $image_name))) {
      File::delete(public_path("images/misc/" . $image_name));
      $new_links = [];
      foreach ($slider_links as $image) {
        if ($image != $image_name) {
          $new_links[] = $image;
        }
      }
      $site_home_slider->value = json_encode($new_links);
      $site_home_slider->update();
    }
    return back()->with('success', 'slider images deleted');
  }

  public function all_properties()
  {
    // $all_properties = Property::latest()->paginate(10);
    return view('admin.all_properties');
  }

  public function pending_properties()
  {
    // $pending_properties = Property::where('status', 'pending')->latest()->paginate(10);
    return view('admin.pending_properties');
  }

  public function active_properties()
  {
    // $active_properties = Property::where('status', 'active')->latest()->paginate(10);
    return view('admin.active_properties');
  }

  public function declined_properties()
  {
    // $declined_properties = Property::where('status', 'declined')->latest()->paginate(10);
    return view('admin.declined_properties');
  }

  public function closed_properties()
  {
    // $closed_properties = Property::where('status', 'closed')->latest()->paginate(10);
    return view('admin.closed_properties');
  }

  public function reported_properties()
  {
    // $closed_properties = Property::where('status', 'reported')->latest()->paginate(10);
    return view('admin.reported_properties');
  }

  public function disabled_properties()
  {
    // $disabled_properties = Property::where('status', 'disabled')->latest()->paginate(10);
    return view('admin.disabled_properties');
  }

  public function all_reports()
  {
    $reports = Report::with('reporter')->paginate(10);
    return view('admin.all_reports', ['reports' => $reports]);
  }

  public function pending_reports()
  {
    $reports = Report::with('reporter')->where('status', 'pending')->with('property_owner')->paginate(10);
    return view('admin.pending_reports', ['reports' => $reports]);
  }

  public function resolved_reports()
  {
    $reports = Report::with('reporter')->where('status', 'resolved')->with('property_owner')->paginate(10);
    return view('admin.resolved_reports', ['reports' => $reports]);
  }

  public function expired_properties()
  {
    $expired_properties = Property::where('status', 'expired')->latest()->paginate(10);
    return view('admin.expired_properties', ['properties' => $expired_properties]);
  }


  public function enable_property($property_id)
  {
    $property = Property::where('id', $property_id)->firstOrFail();
    $property->status = 'active';
    $property->update();
    return back()->with('success', 'Property Approved!');
  }

  public function disable_property($property_id)
  {
    $property = Property::where('id', $property_id)->firstOrFail();
    $property->status = 'disabled';
    $property->update();
    return back()->with('success', 'Property Disabled!');
  }

  public function report_property($property_id)
  {
    $property = Property::where('id', $property_id)->firstOrFail();
    $property->status = 'reported';
    $property->blocked_at = now();
    $property->update();
    return back()->with('success', 'Property Reported!');
  }

  public function close_property($property_id)
  {
    $property = Property::where('id', $property_id)->firstOrFail();
    $property->status = 'closed';
    $property->update();
    return back()->with('success', 'Property Closed!');
  }

  public function all_users()
  {
    $all_users = User::latest()->paginate(10);
    return view('admin.all_users', ['users' => $all_users]);
  }

  public function agent_users()
  {
    $all_users = User::where('role', 'agent')->latest()->paginate(10);
    return view('admin.agent_users', ['users' => $all_users]);
  }

  public function verified_users()
  {
    $all_users = User::where('verification_status', true)->latest()->paginate(10);
    return view('admin.verified_users', ['users' => $all_users]);
  }

  public function verify_user($user_id)
  {
    $user = User::where('id', $user_id)->firstOrFail();
    $user->verification_status = True;
    $user->update();
    return back()->with('success', 'User Verified!');
  }

  public function block_user($user_id)
  {
    $user = User::where('id', $user_id)->firstOrFail();
    $user->status = 'blocked';
    $user->update();
    return back()->with('success', 'User Blocked!');
  }

  public function unblock_user($user_id)
  {
    $user = User::where('id', $user_id)->firstOrFail();
    $user->status = 'active';
    $user->blocked_at = null;
    $user->update();
    return back()->with('success', 'User Unblocked!');
  }

  public function unverify_user($user_id)
  {
    $user = User::where('id', $user_id)->firstOrFail();
    $user->verification_status = false;
    $user->update();
    return back()->with('success', 'User Unverified!');
  }


  public function unverified_users()
  {
    $all_users = User::where('verification_status', false)->latest()->paginate(10);
    return view('admin.unverified_users', ['users' => $all_users]);
  }
  public function reported_users()
  {
    $all_users = User::where('status', 'reported')->latest()->paginate(10);
    return view('admin.reported_users', ['users' => $all_users]);
  }

  public function blocked_users()
  {
    $all_users = User::whereNotNull('blocked_at')->orWhere('status', 'blocked')->latest()->paginate(10);
    return view('admin.blocked_users', ['users' => $all_users]);
  }
  public function active_users()
  {
    $all_users = User::whereNull('blocked_at')->Where('status', 'active')->latest()->paginate(10);
    return view('admin.active_users', ['users' => $all_users]);
  }

  public function all_categories()
  {
    $all_categories = Category::latest()->paginate(10);
    return view('admin.all_categories', ['categories' => $all_categories]);
  }

  public function new_category()
  {
    return view('admin.create_category');
  }


  public function store_category(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|string|min:3|max:255|unique:categories,name',
      'image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);
    try {
      $data = $request->all();
      if ($request->hasFile('image')) {
        $image = $request->file('image');
        $path = public_path('images/categories/');
        $image_ext = $image->getClientOriginalExtension();
        $image_name = sprintf("cat%s.%s", bin2hex(random_bytes(15)), $image_ext);
        $image->move($path, $image_name);
        $data['image'] = $image_name;
      }
      Category::create($data);
      return redirect()->route('admin_all_categories')->with('success', 'Category Created!');
    } catch (Exception $e) {
      return back()->with('error', $e->getMessage())->withInput();
    }
  }

  public function edit_category($category_id)
  {
    $category = Category::where('id', $category_id)->firstOrFail();
    return view('admin.edit_category', ['category' => $category]);
  }

  public function update_category(Request $request, $category_id)
  {
    $this->validate($request, [
      'name' => 'required|string|min:3|max:255|unique:categories,name,' . $category_id,
      'image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);
    try {
      $category = Category::where('id', $category_id)->firstOrFail();
      $data = $request->all();
      if ($request->hasFile('image')) {
        $image = $request->file('image');
        $path = public_path('images/categories/');
        $image_ext = $image->getClientOriginalExtension();
        $image_name = sprintf("cat%s.%s", bin2hex(random_bytes(15)), $image_ext);
        $image->move($path, $image_name);
        $data['image'] = $image_name;
        if ($category->image !== null) {
          if (File::exists(public_path("images/categories/" . $category->image))) {
            File::delete(public_path("images/categories/" . $category->image));
          }
        }
      }
      $category->update($data);
      return redirect()->route('admin_all_categories')->with('success', 'Category Updated!');
    } catch (Exception $e) {
      return back()->with('error', $e->getMessage())->withInput();
    }
  }

  public function all_subcategories()
  {
    $all_subcategories = Subcategory::latest()->paginate(10);
    return view('admin.all_subcategories', ['subcategories' => $all_subcategories]);
  }

  public function new_subcategory()
  {
    $categories = Category::select('id', 'name')->get();
    return view('admin.create_subcategory', ['categories' => $categories]);
  }

  public function store_subcategory(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|string|min:3|max:255|unique:categories,name',
      'category_id' => 'required|numeric|exists:categories,id',
      'image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',

    ]);
    try {
      $data = $request->all();
      if ($request->hasFile('image')) {
        $image = $request->file('image');
        $path = public_path('images/subcategories/');
        $image_ext = $image->getClientOriginalExtension();
        $image_name = sprintf("subcat%s.%s", bin2hex(random_bytes(15)), $image_ext);
        $image->move($path, $image_name);
        $data['image'] = $image_name;
      }
      Subcategory::create($data);
      return redirect()->route('admin_all_subcategories')->with('success', 'Subcategory Updated!');
    } catch (Exception $e) {
      return back()->with('error', $e->getMessage())->withInput();
    }
  }

  public function edit_subcategory($subcategory_id)
  {
    $categories = Category::select('id', 'name')->get();
    $subcategory = Subcategory::where('id', $subcategory_id)->firstOrFail();
    return view('admin.edit_subcategory', ['categories' => $categories, 'subcategory' => $subcategory]);
  }
  public function update_subcategory(Request $request, $subcategory_id)
  {
    $this->validate($request, [
      'name' => 'required|string|min:3|max:255|unique:categories,name,' . $subcategory_id,
      'category_id' => 'required|numeric|exists:categories,id',
      'image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',

    ]);
    try {
      $subcategory = Subcategory::where('id', $subcategory_id)->firstOrFail();
      $data = $request->all();
      if ($request->hasFile('image')) {
        $image = $request->file('image');
        $path = public_path('images/subcategories/');
        $image_ext = $image->getClientOriginalExtension();
        $image_name = sprintf("subcat%s.%s", bin2hex(random_bytes(15)), $image_ext);
        $image->move($path, $image_name);
        $data['image'] = $image_name;
        if ($subcategory->image !== null) {
          if (File::exists(public_path("images/subcategories/" . $subcategory->image))) {
            File::delete(public_path("images/subcategories/" . $subcategory->image));
          }
        }
      }
      $subcategory->update($data);
      return redirect()->route('admin_all_subcategories')->with('success', 'Subcategory Updated!');
    } catch (Exception $e) {
      return back()->with('error', $e->getMessage())->withInput();
    }
  }
}
