<?php

namespace App\Http\Controllers\API;

use App\Amenity;
use App\Category;
use App\FavouriteProperty;
use App\Http\Controllers\Controller;
use App\Notifications\PropertyStatusChanged;
use App\Notifications\SimilarProperty;
use App\Property;
use App\PropertyView;
use App\SiteConfig;
use App\Specification;
use App\State;
use App\Subcategory;
use App\Subscriber;
use App\Subscription;
use App\Tag;
use App\TransactionRecord;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
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
    try {
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
          'expired',
          'declined',
          'disabled'
        ];
        if (in_array($status, $item_status_map)) {
          if ($status == 'all') {
            $item_status  = [
              'closed',
              'active',
              'pending',
              'reported',
              'expired',
              'declined',
              'disabled'
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
      return response()->json($properties, Response::HTTP_OK);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
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
    $category_map = [];
    $subcategory_map = [];
    foreach ($categories as $category) {
      $category_map[] = $category->id;
    }
    foreach ($subcategories as $subcategory) {
      $subcategory_map[] = $subcategory->id;
    }
    $category = $request->has('category') ? $request->category : null;
    $subcategory = $request->has('subcategory') ? $request->subcategory : null;
    $status = $request->has('status') ? $request->status : null;
    $list_as = $request->has('list_as') ? $request->list_as : null;
    $plan = $request->has('plan') ? $request->plan : null;
    $sort_type = $request->has('sort_type') ? $request->sort_type : null;
    $sort_by = $request->has('sort_by') ? $request->sort_by : null;
    $min_price = $request->has('min_price') ? $request->min_price : 0;
    $max_price = $request->has('max_price') ? $request->max_price : 99999999999999;
    $result_count = $request->has('result_count') ? $request->result_count : 9;

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

    $item_plan = function () use ($plan) {
      $item_plan_map = [
        'all',
        'free',
        'vip',
        'featured',
        'premium',
      ];
      if (in_array($plan, $item_plan_map)) {
        if ($plan == 'all') {
          return ['free', 'vip', 'featured', 'premium',];
        }
        return [$plan];
      } else {
        return ['free', 'vip', 'featured', 'premium',];
      }
    };

    $item_category = function () use ($category, $category_map) {
      if (in_array($category, $category_map)) {
        return [$category];
      } else {
        return $category_map;
      }
    };

    $item_subcategory = function () use ($subcategory, $subcategory_map) {
      if (in_array($subcategory, $subcategory_map)) {
        return [$subcategory];
      } else {
        return $subcategory_map;
      }
    };

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

    $item_min_price = $min_price;
    $item_max_price = $max_price;

    $item_result_count = function () use ($result_count) {
      if (in_array($result_count, [9, 18, 36, 72, 90, 108])) {
        return $result_count;
      } else {
        return 9;
      }
    };
    try {
      $properties = Property::with([
        'user', 'user.state', 'user.city',
        'tags', 'amenities', 'specifications',
        'category', 'subcategory', 'state', 'city'
      ])
        ->where('user_id', Auth()->user()->id)
        ->whereIn('category_id', $item_category())
        ->whereIn('subcategory_id', $item_subcategory())
        ->whereIn('status', $item_status())
        ->whereIn('plan', $item_plan())
        ->whereIn('list_as', $item_list_as())
        ->whereBetween('price', [$item_min_price, $item_max_price])
        ->orderBy($item_sort_by(), $item_sort_type())
        ->paginate($item_result_count());
      return response()->json($properties, Response::HTTP_OK);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }


  public function find(Request $request)
  {
    $categories = Category::select('id')->get();
    $states = State::select('id')->get();
    $category_map = [];
    $state_map = [];
    foreach ($categories as $category) {
      $category_map[] = $category->id;
    }
    foreach ($states as $state) {
      $state_map[] = $state->id;
    }
    $category = $request->has('category') ? $request->category : null;
    $state = $request->has('state') ? $request->state : null;
    $result_count = $request->has('result_count') ? $request->result_count : 9;
    $sort_type = $request->has('sort_type') ? $request->sort_type : null;
    $sort_by = $request->has('sort_by') ? $request->sort_by : null;
    $findable = $request->has('findable') ? $request->findable : null;

    $item_category = function () use ($category, $category_map) {
      if (in_array($category, $category_map)) {
        return [$category];
      } else {
        return $category_map;
      }
    };

    $item_state = function () use ($state, $state_map) {
      if (in_array($state, $state_map)) {
        return [$state];
      } else {
        return $state_map;
      }
    };



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

    $item_result_count = function () use ($result_count) {
      if (in_array($result_count, [9, 18, 36, 72, 90, 108])) {
        return $result_count;
      } else {
        return 9;
      }
    };

    if ($findable == null) {
      try {
        $properties = Property::with('user:first_name,last_name,username,phone,email,avatar,verification_status')
          ->with('tags:name')
          ->with('amenities:name,value')
          ->with('specifications:name,value')
          ->with('category')
          ->with('subcategory')
          ->with('state')
          ->with('city')
          ->whereIn('category_id', $item_category())
          ->whereIn('state_id', $item_state())
          ->orderBy($item_sort_by(), $item_sort_type())
          ->paginate($item_result_count());
        return response()->json($properties, Response::HTTP_OK);
      } catch (\Exception $e) {
        return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    } else {
      try {
        $properties = Property::with('user:first_name,last_name,username,phone,email,avatar,verification_status')
          ->with('tags:name')
          ->with('amenities:name,value')
          ->with('specifications:name,value')
          ->with('category')
          ->with('subcategory')
          ->with('state')
          ->with('city')
          ->whereIn('category_id', $item_category())
          ->whereIn('state_id', $item_state())
          ->where('title', 'LIKE', "%{$findable}%")
          ->orderBy($item_sort_by(), $item_sort_type())
          ->paginate($item_result_count());
        return response()->json($properties, Response::HTTP_OK);
      } catch (\Exception $e) {
        return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    }
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $image_url = [];
    $this->validate($request, [
      'title' => 'required|string|',
      'price' => 'required|integer|between:1000,5000000000000',
      'address' => 'required|string|',
      'category_id' => 'required|exists:categories,id',
      'subcategory_id' => 'required|exists:subcategories,id',
      'state_id' => 'required|exists:states,id',
      'city_id' => 'required|exists:cities,id',
      'phone' => 'required|string|',
      'images.*' => 'file|image|mimes:jpeg,png,gif,jpg|max:2048',
      'list_as' => 'required|string|',
      'plan' => 'required|string|',
      'description' => 'nullable|string|',
      'tags.*' => 'string',
      'amenities' => 'nullable|array|min:0',
      'amenities.*.name' => 'nullable|string',
      'amenities.*.value' => 'nullable|string',
      'specifications' => 'nullable|array|min:0',
      'specifications.*.name' => 'nullable|string',
      'specifications.*.value' => 'nullable|string',
    ], [
      'title.required' => 'The property title is required',
      'price.required' => 'The property price is required',
      'category_id.required' => 'please select a category',
      'subcategory_id.required' => 'please select a subcategory',
      'state_id.required' => 'State location of the property is required',
      'city_id.required' => 'LGA location of the property is required',
    ]);

    try {

      $new_property = new Property();
      $new_property->title = $request->input('title');
      $new_property->price = $request->input('price');
      $new_property->address = $request->input('address');
      $new_property->category_id = $request->input('category_id');
      $new_property->subcategory_id = $request->input('subcategory_id');
      $new_property->state_id = $request->input('state_id');
      $new_property->city_id = $request->input('city_id');
      $new_property->phone = $request->input('phone');
      $new_property->list_as = $request->input('list_as');
      $new_property->plan = 'free';
      $new_property->status = "pending";
      $new_property->description = $request->input('description');
      $new_property->images = [];
      $new_property->user_id = Auth::User()->id;
      $new_property->views = 0;
      $new_property->likes = 0;
      $new_property->save();

      $new_property->user()->associate(Auth::User()->id);
      if ($request->has('tags') && is_array($request->input('tags')) && count($request->input('tags'))) {
        $tags = $request->input('tags');
        foreach ($tags as $tag) {
          $creatable_tag = Tag::firstOrCreate(
            ['name' => $tag]
          );
          $new_property->tags()->attach(
            [
              $creatable_tag->id,
            ]
          );
        }
      }

      if ($request->has('amenities') && is_array($request->input('amenities')) && count($request->input('amenities'))) {
        $amenities = $request->input('amenities');
        foreach ($amenities as $amenity) {
          $creatable_amenity = Amenity::firstOrCreate(
            [
              'name' => $amenity['name'],
              'category_id' => $request->input('category_id'),
            ]
          );
          $new_property->amenities()->attach(
            [
              $creatable_amenity->id =>
              ['value' => $amenity['value']],
            ]
          );
        }
      }

      if ($request->has('specifications') && is_array($request->input('specifications')) && count($request->input('specifications'))) {
        $specifications = $request->input('specifications');
        foreach ($specifications as $specification) {
          $creatable_specification = Specification::firstOrCreate(
            [
              'name' => $specification['name'],
              'category_id' => $request->input('category_id'),
            ]
          );
          $new_property->specifications()->attach(
            [
              $creatable_specification->id =>
              ['value' => $specification['value'],],
            ]
          );
        }
      }

      if ($request->hasFile('images')) {
        $images = $request->file('images');
        foreach ($images as $image) {
          $img_ext = $image->getClientOriginalExtension();
          $img_name = sprintf("P%s.%s", now()->format('YmdHisu'), $img_ext);
          $img_path = public_path("images/properties/{$new_property->id}");
          $image->move($img_path, $img_name);
          $image_url[] = $img_name;
        }
        $new_property->images = $image_url;
        $new_property->update();
      }

      if ($request->input('plan') != 'free') {
        $property_plan = SiteConfig::where('key', 'property_plan_fee')->firstOrFail();
        $property_plan_fee = json_decode($property_plan->value);
        $paystack_keys = SiteConfig::where('key', 'paystack_keys')->firstOrFail();
        $paystack_keys_value = json_decode($paystack_keys->value);
        $paystack_secret_key = $paystack_keys_value->secret;

        if ($request->input('plan') == 'vip') {
          $fee = $property_plan_fee->vip * 100;
        } elseif ($request->input('plan') == 'premium') {
          $fee = $property_plan_fee->premium * 100;
        } else {
          $fee = $property_plan_fee->featured * 100;
        }
        $paystack =  new Paystack();
        $request->reference = $paystack->genTranxRef();
        $request->amount = ($fee);
        $request->quantity = 1;
        $request->email = Auth::user()->email;
        $request->metadata = ['property_id' => $new_property->id, 'user_id' => Auth::User()->id, 'plan' => $request->input('plan')];
        $request->key = $paystack_secret_key;
        $request->callback_url = route('payment_callback');
        $request->request->remove('plan');

        $new_trx_record = new TransactionRecord();
        $new_trx_record->payment_gateway = 'paystack';
        $new_trx_record->amount = ($fee / 100);
        $new_trx_record->status = 'pending';
        $new_trx_record->transaction_ref = $request->reference;
        $new_trx_record->property_id = $new_property->id;
        $new_trx_record->user_id = Auth::User()->id;
        $new_trx_record->save();
        $checkout_url = $paystack->getAuthorizationUrl();
        // $pcat = $new_property->category_id;
        // $pscat = $new_property->subcategory_id;
        // $pstate = $new_property->state_id;
        // $notif_subs = Subscriber::whereHas('subscribers', function ($filter) use ($pcat, $pscat, $pstate) {
        //   $filter->where('state_id', $pstate)
        //     ->where('category_id', $pcat)
        //     ->orWhere('subcategory_id', $pscat);
        // })->get();
        // foreach ($notif_subs as $notif) {
        //   $notif->notify(new SimilarProperty($notif, $new_property));
        // }
        return response()->json($checkout_url, Response::HTTP_CREATED);
      }

      return response()->json('Property Has been Uploaded', Response::HTTP_CREATED);
    } catch (\Exception $e) {
      $message = sprintf("message: %s. Error File: %s. Error Line: %s", $e->getMessage(), $e->getFile(), $e->getLine());
      return response()->json(
        $message,
        Response::HTTP_INTERNAL_SERVER_ERROR
      );
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    try {
      $property = Property::where('id', $id)->firstOrFail();
      $success['data'] = $property;
      return response()->json([
        'success' => $success,
      ], Response::HTTP_OK);
    } catch (ModelNotFoundException $mnt) {
      return response()->json([
        'error' => 'No Item Found',
      ], Response::HTTP_NOT_FOUND);
    } catch (\Exception $e) {
      return response()->json([
        'error' => $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    if (Property::where('id', $id)->exists()) {
      $updateable_property = Property::where('id', $id)->firstOrFail();
      $this->validate($request, [
        'title' => 'required|string|',
        'price' => 'required|integer|between:1000,5000000000000',
        'address' => 'required|string|',
        'category_id' => 'required|numeric|',
        'subcategory_id' => 'required|numeric|',
        'state_id' => 'required|numeric|exists:states,id',
        'city_id' => 'required|exists:cities,id',
        'phone' => 'required|string|',
        'updateable_images' => 'array|min:0',
        'images.*' => 'file|image|mimes:jpeg,png,gif,jpg|max:2048',
        'list_as' => 'required|string|',
        'plan' => 'required|string|',
        'description' => 'nullable|string|',
        'tags.*' => 'string',
        'amenities' => 'nullable|array|min:0',
        'amenities.*.name' => 'nullable|string',
        'amenities.*.value' => 'nullable|string',
        'specifications' => 'nullable|array|min:0',
        'specifications.*.name' => 'nullable|string',
        'specifications.*.value' => 'nullable|string',
      ], [
        'title.required' => 'The property title is required',
        'price.required' => 'The property price is required',
        'category_id.required' => 'please select a category',
        'subcategory_id.required' => 'please select a subcategory',
        'state_id.required' => 'State location of the property is required',
        'city_id.required' => 'LGA location of the property is required',
      ]);

      try {
        $updateable_property->title = $request->input('title');
        $updateable_property->price = $request->input('price');
        $updateable_property->address = $request->input('address');
        $updateable_property->category_id = $request->input('category_id');
        $updateable_property->subcategory_id = $request->input('subcategory_id');
        $updateable_property->state_id = $request->input('state_id');
        $updateable_property->city_id = $request->input('city_id');
        $updateable_property->phone = $request->input('phone');
        $updateable_property->list_as = $request->input('list_as');
        $updateable_property->description = $request->input('description');
        $updateable_property->user_id = Auth::User()->id;
        $updateable_property->views = 0;
        $updateable_property->likes = 0;



        if ($request->has('tags') && is_array($request->input('tags')) && count($request->input('tags'))) {
          $tags = $request->input('tags');
          $updateable_tag_arr = [];
          foreach ($tags as $tag) {
            //attach the new tags from the database
            $creatable_tag = Tag::firstOrCreate(
              ['name' => $tag]
            );
            $updateable_tag_arr[] = $creatable_tag->id;
          }
          $updateable_property->tags()->sync($updateable_tag_arr);
        } else {
          $updateable_property->tags()->detach();
        }

        //attach Amentities
        if ($request->has('amenities') && is_array($request->input('amenities')) && count($request->input('amenities'))) {
          $amenities = $request->input('amenities');
          $updateable_amenities_arr = [];
          foreach ($amenities as $amenity) {
            $creatable_amenity = Amenity::firstOrCreate(
              [
                'name' => $amenity['name'],
                'category_id' => $request->input('category_id'),
              ]
            );
            $updateable_amenities_arr[$creatable_amenity->id] = ['value' => $amenity['value']];
          }
          $updateable_property->amenities()->sync($updateable_amenities_arr);
        } else {
          $updateable_property->amenities()->detach();
        }

        if ($request->has('specifications') && is_array($request->input('specifications')) && count($request->input('specifications')) >= 1) {
          $specifications = $request->input('specifications');
          $updateable_specifications_arr = [];
          foreach ($specifications as $specification) {
            $creatable_specification = Specification::firstOrCreate(
              [
                'name' => $specification['name'],
                'category_id' => $request->input('category_id'),
              ]
            );
            $updateable_specifications_arr[$creatable_specification->id] = ['value' => $specification['value']];
          }
          $updateable_property->specifications()->sync($updateable_specifications_arr);
        } else {
          $updateable_property->specifications()->detach();
        }

        //adding more images if uploaded
        if ($request->hasFile('images')) {
          $allowed_media = SiteConfig::where('key', 'property_max_media')->firstOrFail();
          $image_remains = $allowed_media->value - count($updateable_property->images);
          $image_url = [];
          $images = $request->file('images');
          $rem = $image_remains;
          foreach ($images as $image) {
            if ($rem >= 1) {
              $img_ext = $image->getClientOriginalExtension();
              $img_name = sprintf("P%s.%s", now()->format('YmdHisu'), $img_ext);
              $img_path = public_path("images/properties/{$updateable_property->id}");
              $image->move($img_path, $img_name);
              $image_url[] = $img_name;
              $rem--;
            } else {
              break;
            }
          }
          $updateable_property->images = array_merge($image_url, $updateable_property->images);
          $updateable_property->update();
        }

        $updateable_property->update();


        if ($request->input('plan') != 'free') {
          if ($updateable_property->expires_at < now()) {
            if ($updateable_property->transactions()->where('status', 'success')->exists()) {
              $last_property_transaction = $updateable_property->transactions()->where('status', 'success')->latest()->first();
              if ($last_property_transaction->plan != $request->input('plan')) {
                $property_plan = SiteConfig::where('key', 'property_plan_fee')->firstOrFail();
                $property_plan_fee = json_decode($property_plan->value);
                $paystack_keys = SiteConfig::where('key', 'paystack_keys')->firstOrFail();
                $paystack_keys_value = json_decode($paystack_keys->value);
                $paystack_secret_key = $paystack_keys_value->secret;

                if ($request->input('plan') == 'vip') {
                  $fee = $property_plan_fee->vip * 100;
                } elseif ($request->input('plan') == 'premium') {
                  $fee = $property_plan_fee->premium * 100;
                } else {
                  $fee = $property_plan_fee->featured * 100;
                }
                $paystack =  new Paystack();
                $request->reference = $paystack->genTranxRef();
                $request->amount = ($fee);
                $request->quantity = 1;
                $request->email = Auth::user()->email;
                $request->metadata = ['property_id' => $updateable_property->id, 'user_id' => Auth::User()->id, 'plan' => $request->input('plan')];
                $request->key = $paystack_secret_key;
                $request->callback_url = route('payment_callback');

                $new_trx_record = new TransactionRecord();
                $new_trx_record->payment_gateway = 'paystack';
                $new_trx_record->amount = ($fee / 100);
                $new_trx_record->status = 'pending';
                $new_trx_record->plan = $request->input('plan');
                $new_trx_record->transaction_ref = $request->reference;
                $new_trx_record->property_id = $updateable_property->id;
                $new_trx_record->user_id = Auth::User()->id;
                $new_trx_record->save();


                $request->request->remove('plan');
                $checkout_url = $paystack->getAuthorizationUrl();
                return response()->json($checkout_url, Response::HTTP_CREATED);
              } else {
                $updateable_property->plan = $last_property_transaction->plan;
                $updateable_property->update();
              }
            } else {
              $property_plan = SiteConfig::where('key', 'property_plan_fee')->firstOrFail();
              $property_plan_fee = json_decode($property_plan->value);
              $paystack_keys = SiteConfig::where('key', 'paystack_keys')->firstOrFail();
              $paystack_keys_value = json_decode($paystack_keys->value);
              $paystack_secret_key = $paystack_keys_value->secret;

              if ($request->input('plan') == 'vip') {
                $fee = $property_plan_fee->vip * 100;
              } elseif ($request->input('plan') == 'premium') {
                $fee = $property_plan_fee->premium * 100;
              } else {
                $fee = $property_plan_fee->featured * 100;
              }
              $paystack =  new Paystack();
              $request->reference = $paystack->genTranxRef();
              $request->amount = ($fee);
              $request->quantity = 1;
              $request->email = Auth::user()->email;
              $request->metadata = ['property_id' => $updateable_property->id, 'user_id' => Auth::User()->id, 'plan' => $request->input('plan')];
              $request->key = $paystack_secret_key;
              $request->callback_url = route('payment_callback');

              $new_trx_record = new TransactionRecord();
              $new_trx_record->payment_gateway = 'paystack';
              $new_trx_record->amount = ($fee / 100);
              $new_trx_record->status = 'pending';
              $new_trx_record->plan = $request->input('plan');
              $new_trx_record->transaction_ref = $request->reference;
              $new_trx_record->property_id = $updateable_property->id;
              $new_trx_record->user_id = Auth::User()->id;
              $new_trx_record->save();

              $updateable_property->plan = 'free';
              $updateable_property->update();
              $request->request->remove('plan');
              $checkout_url = $paystack->getAuthorizationUrl();
              return response()->json($checkout_url, Response::HTTP_CREATED);
            }
          } else {
            $last_property_transaction = $updateable_property->transactions()->where('status', 'success')->latest()->first();
            if ($last_property_transaction->plan != $request->input('plan')) {
              $property_plan = SiteConfig::where('key', 'property_plan_fee')->firstOrFail();
              $property_plan_fee = json_decode($property_plan->value);
              $paystack_keys = SiteConfig::where('key', 'paystack_keys')->firstOrFail();
              $paystack_keys_value = json_decode($paystack_keys->value);
              $paystack_secret_key = $paystack_keys_value->secret;

              if ($request->input('plan') == 'vip') {
                $fee = $property_plan_fee->vip * 100;
              } elseif ($request->input('plan') == 'premium') {
                $fee = $property_plan_fee->premium * 100;
              } else {
                $fee = $property_plan_fee->featured * 100;
              }
              $paystack =  new Paystack();
              $request->reference = $paystack->genTranxRef();
              $request->amount = ($fee);
              $request->quantity = 1;
              $request->email = Auth::user()->email;
              $request->metadata = ['property_id' => $updateable_property->id, 'user_id' => Auth::User()->id, 'plan' => $request->input('plan')];
              $request->key = $paystack_secret_key;
              $request->callback_url = route('payment_callback');

              $new_trx_record = new TransactionRecord();
              $new_trx_record->payment_gateway = 'paystack';
              $new_trx_record->amount = ($fee / 100);
              $new_trx_record->status = 'pending';
              $new_trx_record->plan = $request->input('plan');
              $new_trx_record->transaction_ref = $request->reference;
              $new_trx_record->property_id = $updateable_property->id;
              $new_trx_record->user_id = Auth::User()->id;
              $new_trx_record->save();


              $request->request->remove('plan');
              $checkout_url = $paystack->getAuthorizationUrl();
              return response()->json($checkout_url, Response::HTTP_CREATED);
            }
          }
        } else {
          $updateable_property->plan = 'free';
          $updateable_property->update();
        }

        return response()->json('Property Has been Updated', Response::HTTP_CREATED);
      } catch (\Exception $e) {
        $message = sprintf("message: %s. Error File: %s. Error Line: %s", $e->getMessage(), $e->getFile(), $e->getLine());
        return response()->json(
          $message,
          Response::HTTP_INTERNAL_SERVER_ERROR
        );
      }
    } else {
      return response()->json("No Item Found to update", Response::HTTP_NOT_FOUND);
    }
  }

  public function delete_property_image($property_slug, $image_name)
  {
    $property = Property::where('slug', $property_slug)->firstOrFail();
    try {
      $image_links = $property->images;
      if (File::exists(public_path(sprintf("images/properties/%s/%s", $property->id, $image_name)))) {
        File::delete(public_path(sprintf("images/properties/%s/%s", $property->id, $image_name)));
        $new_links = [];
        foreach ($image_links as $image) {
          if ($image != $image_name) {
            $new_links[] = $image;
          }
        }
        $property->images = $new_links;
        $property->update();
      }
      return response()->json($property->images, Response::HTTP_CREATED);
    } catch (\Exception $e) {
      $message = sprintf("message: %s. Error File: %s. Error Line: %s", $e->getMessage(), $e->getFile(), $e->getLine());
      return response()->json(
        $message,
        Response::HTTP_INTERNAL_SERVER_ERROR
      );
    }
  }



  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($property_slug)
  {
    try {
      $property = Property::where('slug', $property_slug)->firstOrFail();
      $property->tags()->detach();
      $property->amenities()->detach();
      $property->specifications()->detach();
      if (File::isDirectory(public_path("images/properties/{$property->id}"))) {
        File::deleteDirectory(public_path("images/properties/{$property->id}"));
      }
      $property->delete();
      return response()->json('Property Deleted!', Response::HTTP_OK);
    } catch (ModelNotFoundException $mnt) {
      return response()->json('No Item Found', Response::HTTP_NOT_FOUND);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }


  public function add_favourite_property($property_id)
  {
    try {
      if (Property::where('id', $property_id)->exists()) {
        FavouriteProperty::updateOrCreate(['property_id' => $property_id, 'user_id' => Auth()->user()->id]);
      }
      return response()->json('Property added to favourite', Response::HTTP_OK);
    } catch (Exception $e) {
      $message = sprintf("message: %s. Error File: %s. Error Line: %s", $e->getMessage(), $e->getFile(), $e->getLine());
      return response()->json(
        $message,
        Response::HTTP_INTERNAL_SERVER_ERROR
      );
    }
  }

  public function user_favourite_property()
  {
    $user = User::where('id', Auth::user()->id)->firstOrFail();
    $properties = FavouriteProperty::where('user_id', $user->id)->with(['property', 'property.state', 'property.city', 'property.category', 'property.subcategory'])->paginate(9);
    // return dd($properties);
    return response()->json($properties, Response::HTTP_OK);
  }


  public function user_transaction(Request $request)
  {
    if ($request->has('status')) {
      $status = $request->status;
      $item_status_map = [
        'all',
        'success',
        'failed',
        'pending',
      ];
      if (in_array($status, $item_status_map)) {
        if ($status == 'all') {
          $item_status  = [
            'success',
            'failed',
            'pending',
          ];
        } else {
          $item_status  = [$status];
        }
      } else {
        $item_status = ["success"];
      }
    } else {
      $item_status = false;
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

    $transactions = TransactionRecord::with(['property'])
      ->where('user_id', Auth::user()->id)
      ->when($item_status, function ($query) use ($item_status) {
        return $query->whereIn('status', $item_status);
      })
      ->orderBy($item_sort_by, $item_sort_type)
      ->paginate($item_result_count)->appends(request()->query());
    return response()->json($transactions, Response::HTTP_OK);
  }



  public function user_property_view()
  {
    $properties = PropertyView::with(['property', 'user'])->whereHas('property', function ($query) {
      return $query->where('user_id', Auth::user()->id);
    })->paginate(9);
    // return dd($properties);
    return response()->json($properties, Response::HTTP_OK);
  }

  public function remove_favourite_property($property_id)
  {
    try {
      if (Property::where('id', $property_id)->exists()) {
        $data = FavouriteProperty::where('property_id', $property_id)->where('user_id', Auth()->user()->id)->firstOrFail();
        $data->delete();
        return response()->json('Property removed from Favourite', Response::HTTP_OK);
      }
    } catch (Exception $e) {
      $message = sprintf("message: %s. Error File: %s. Error Line: %s", $e->getMessage(), $e->getFile(), $e->getLine());
      return response()->json(
        $message,
        Response::HTTP_INTERNAL_SERVER_ERROR
      );
    }
  }

  /**
   * disabled specified resource .
   *
   * @param  int  $action,$id
   * @return \Illuminate\Http\Response
   */
  public function switchProductStatus($property_id, $status = null)
  {
    $status_map = ['disabled', 'active', 'expired', 'closed', 'reported', 'pending', 'declined'];
    if (in_array($status, $status_map)) {
      $property_status = $status;
    } else {
      return response()->json('Invalid Action', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    if ($property_status != null) {
      try {
        $property = Property::where('id', $property_id)->firstOrFail();
        $property->status = $property_status;
        if ($property_status == 'reported') {
          $property->reported_at = now();
        }
        $property->update();
        $property_owner = User::where('id', $property->user_id)->firstOrFail();
        // $property_owner->notify(new PropertyStatusChanged($property_owner,$property));
        return response()->json(sprintf("Property is now %s !", ucwords($property_status)), Response::HTTP_OK);
      } catch (ModelNotFoundException $mnt) {
        return response()->json('No Item Found', Response::HTTP_NOT_FOUND);
      } catch (\Exception $e) {
        return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    } else {
    }
  }

  public function userCloseProperty($property_slug)
  {
    try {
      $property = Property::where('slug', $property_slug)->firstOrFail();
      $property->status = 'closed';
      $property->update();
      return response()->json("Property is now Closed !", Response::HTTP_OK);
    } catch (ModelNotFoundException $mnt) {
      return response()->json('No Item Found', Response::HTTP_NOT_FOUND);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function upgrade_property(Request $request)
  {
    $property = Property::where('slug', $request->property_slug)->firstOrFail();
    if ($property->plan != $request->plan) {
      $property_plan = SiteConfig::where('key', 'property_plan_fee')->firstOrFail();
      $property_plan_fee = json_decode($property_plan->value);
      $paystack_keys = SiteConfig::where('key', 'paystack_keys')->firstOrFail();
      $paystack_keys_value = json_decode($paystack_keys->value);
      $paystack_secret_key = $paystack_keys_value->secret;

      if ($request->plan == 'vip') {
        $fee = $property_plan_fee->vip * 100;
      } elseif ($request->plan == 'premium') {
        $fee = $property_plan_fee->premium * 100;
      } else {
        $fee = $property_plan_fee->featured * 100;
      }
      $paystack =  new Paystack();
      $request->reference = $paystack->genTranxRef();
      $request->amount = ($fee);
      $request->quantity = 1;
      $request->email = Auth::user()->email;
      $request->metadata = ['property_id' => $property->id, 'user_id' => Auth::User()->id, 'plan' => $request->plan];
      $request->key = $paystack_secret_key;
      $request->callback_url = route('payment_callback');
      $request->request->remove('plan');

      $new_trx_record = new TransactionRecord();
      $new_trx_record->payment_gateway = 'paystack';
      $new_trx_record->amount = ($fee / 100);
      $new_trx_record->status = 'pending';
      $new_trx_record->transaction_ref = $request->reference;
      $new_trx_record->property_id = $property->id;
      $new_trx_record->user_id = Auth::User()->id;
      $new_trx_record->save();
      $checkout_url = $paystack->getAuthorizationUrl();
      return response()->json($checkout_url, Response::HTTP_CREATED);
    } else {
      return response()->json(sprintf('Property is Already on %s plan!', $request->plan), Response::HTTP_OK);
    }
  }
}
