<?php

namespace App\Http\Controllers\API;

use App\Amenity;
use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\Specification;
use App\State;
use App\Subcategory;
use App\Tag;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
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

    if (Auth()->user()->is_user()) {
      try {
        $products = Product::with('user:first_name,last_name,username,phone,email,avatar,verification_status')
          ->with('tags:name')
          ->with('amenities:name,value')
          ->with('specifications:name,value')
          ->with('category')
          ->with('subcategory')
          ->with('state')
          ->with('city')
          ->whereIn('category_id', $item_category())
          ->whereIn('subcategory_id', $item_subcategory())
          ->whereIn('status', $item_status())
          ->whereIn('plan', $item_plan())
          ->whereIn('list_as', $item_list_as())
          ->whereBetween('price', [$item_min_price, $item_max_price])
          ->orderBy($item_sort_by(), $item_sort_type())
          ->paginate($item_result_count());
        return response()->json($products, Response::HTTP_OK);
      } catch (\Exception $e) {
        return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    } elseif (Auth()->user()->is_agent()) {
      try {
        $products = $products = Product::with('users:first_name,last_name,username,phone,email,avatar,verification_status')
          ->with('tags:name')
          ->with('amenities:name,value')
          ->with('specifications:name,value')
          ->with('categories:name')
          ->with('subcategories:name')
          ->whereIn('category_id', $item_category())
          ->whereIn('subcategory_id', $item_subcategory())
          ->where('status', $item_status())
          ->whereBetween('price', [$item_min_price, $item_max_price])
          ->orderBy($item_sort_by(), $item_sort_type())
          ->paginate($item_result_count());;
        $success['data'] = $products;
        return response()->json([
          'success' => $success,
        ], Response::HTTP_OK);
      } catch (ModelNotFoundException $mnt) {
        return response()->json([
          'error' => 'No Item Found',
        ], Response::HTTP_NOT_FOUND);
      } catch (\Exception $e) {
        return response()->json([
          'error' => sprintf("message: %s. Error File: %s. Error Line: %s", $e->getMessage(), $e->getFile(), $e->getLine()),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    } elseif (Auth()->user()->is_admin()) {
      try {
        $products = $products = Product::with('users:first_name,last_name,username,phone,email,avatar,verification_status')
          ->with('tags:name')
          ->with('amenities:name,value')
          ->with('specifications:name,value')
          ->with('categories:name')
          ->with('subcategories:name')
          ->whereIn('category_id', $item_category())
          ->whereIn('subcategory_id', $item_subcategory())
          ->where('status', $item_status())
          ->whereBetween('price', [$item_min_price, $item_max_price])
          ->orderBy($item_sort_by(), $item_sort_type())
          ->paginate($item_result_count());

        $success['data'] = $products;
        return response()->json([
          'success' => $success,
        ], Response::HTTP_OK);
      } catch (ModelNotFoundException $mnt) {
        return response()->json([
          'error' => 'No Item Found',
        ], Response::HTTP_NOT_FOUND);
      } catch (\Exception $e) {
        return response()->json([
          'error' => sprintf("message: %s. Error File: %s. Error Line: %s", $e->getMessage(), $e->getFile(), $e->getLine()),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
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
        $products = Product::with('user:first_name,last_name,username,phone,email,avatar,verification_status')
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
        return response()->json($products, Response::HTTP_OK);
      } catch (\Exception $e) {
        return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    } else {
      try {
        $products = Product::with('user:first_name,last_name,username,phone,email,avatar,verification_status')
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
        return response()->json($products, Response::HTTP_OK);
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
      'price' => 'required|numeric|',
      'address' => 'required|string|',
      'category_id' => 'required|exists:categories,id',
      'subcategory_id' => 'required|exists:subcategories,id',
      'state_id' => 'required|exists:states,id',
      'city_id' => 'numeric|exists:cities,id',
      'phone' => 'required|string|',
      'images.*' => 'file|image|mimes:jpeg,png,gif,jpg|max:2048',
      'list_as' => 'required|string|',
      'plan' => 'required|string|',
      'description' => 'nullable|string|',
      'tags.*' => 'alpha_dash',
      'amenities' => 'array|min:0',
      'amenities.*.name' => 'required_unless:amenities.*,null|string',
      'amenities.*.value' => 'required_unless:amenities.*,null|string',
      'specifications' => 'array|min:0',
      'specifications.*.name' => 'required_unless:specifications.*,null|string',
      'specifications.*.value' => 'required_unless:specifications.*,null|string',
    ]);

    try {

      $new_product = new Product();
      $new_product->title = $request->input('title');
      $new_product->price = $request->input('price');
      $new_product->address = $request->input('address');
      $new_product->category_id = $request->input('category_id');
      $new_product->subcategory_id = $request->input('subcategory_id');
      $new_product->state_id = $request->input('state_id');
      $new_product->city_id = $request->input('city_id');
      $new_product->phone = $request->input('phone');
      $new_product->list_as = $request->input('list_as');
      $new_product->plan = $request->input('plan');
      $new_product->status = "pending";
      $new_product->description = $request->input('description');
      $new_product->images = [];
      $new_product->user_id = Auth::User()->id;
      $new_product->views = 0;
      $new_product->likes = 0;
      $new_product->save();

      $new_product->user()->associate(Auth::User()->id);
      $tags = $request->input('tags');
      if (count($tags) >= 1) {
        foreach ($tags as $tag) {
          $creatable_tag = Tag::firstOrCreate(
            ['name' => $tag]
          );
          $new_product->tags()->attach(
            [
              $creatable_tag->id,
            ]
          );
        }
      }

      $amenities = $request->input('amenities');
      if (count($amenities) >= 1) {
        foreach ($amenities as $amenity) {
          $creatable_amenity = Amenity::firstOrCreate(
            [
              'name' => $amenity['name'],
              'category_id' => $request->input('category_id'),
            ]
          );
          $new_product->amenities()->attach(
            [
              $creatable_amenity->id =>
              ['value' => $amenity['value']],
            ]
          );
        }
      }

      $specifications = $request->input('amenities');
      if (count($specifications) >= 1) {
        foreach ($specifications as $specification) {
          $creatable_specification = Specification::firstOrCreate(
            [
              'name' => $specification['name'],
              'category_id' => $request->input('category_id'),
            ]
          );
          $new_product->specifications()->attach(
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
          $img_name = sprintf("P%s.%s", now()->format('YmdHis'), $img_ext);
          $img_path = public_path("images/products/{$new_product->id}");
          $image->move($img_path, $img_name);
          $image_url[] = $img_name;
        }
        $new_product->images = $image_url;
        $new_product->update();
      }
      return response()->json('Product has been posted', Response::HTTP_CREATED);
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
      $product = Product::where('id', $id)->firstOrFail();
      $success['data'] = $product;
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
    if (Product::where('id', $id)->exists()) {
      $updateable_product = Product::where('id', $id)->firstOrFail();
      $this->validate($request, [
        'title' => 'required|string|',
        'price' => 'required|numeric|',
        'address' => 'required|string|',
        'category_id' => 'required|numeric|',
        'subcategory_id' => 'required|numeric|',
        'state_id' => 'required|numeric|exists:states,id',
        'city_id' => 'numeric|exists:cities,id',
        'phone' => 'required|string|',
        'updateable_images' => 'array|min:0',
        'images.*' => 'file|image|mimes:jpeg,png,gif,jpg|max:2048',
        'list_as' => 'required|string|',
        'plan' => 'required|string|',
        'description' => 'nullable|string|',
        'tags.*' => 'string',
        'amenities' => 'array|min:0',
        'amenities.*.name' => 'required_unless:amenities.*,null|string',
        'amenities.*.value' => 'required_unless:amenities.*,null|string',
        'specifications' => 'array|min:0',
        'specifications.*.name' => 'required_unless:specifications.*,null|string',
        'specifications.*.value' => 'required_unless:specifications.*,null|string',
      ]);

      try {
        $updateable_product->title = $request->input('title');
        $updateable_product->price = $request->input('price');
        $updateable_product->address = $request->input('address');
        $updateable_product->category_id = $request->input('category_id');
        $updateable_product->subcategory_id = $request->input('subcategory_id');
        $updateable_product->state_id = $request->input('state_id');
        $updateable_product->city_id = $request->input('city_id');
        $updateable_product->phone = $request->input('phone');
        $updateable_product->list_as = $request->input('list_as');
        $updateable_product->plan = $request->input('plan');
        $updateable_product->description = $request->input('description');
        $updateable_product->user_id = Auth::User()->id;
        $updateable_product->views = 0;
        $updateable_product->likes = 0;
        $updateable_product->update();

        $tags = $request->input('tags');
        if (count($tags) >= 1) {
          $updateable_tag_arr = [];
          foreach ($tags as $tag) {
            //attach the new tags from the database
            $creatable_tag = Tag::firstOrCreate(
              ['name' => $tag]
            );
            $updateable_tag_arr[] = $creatable_tag->id;
          }
          $updateable_product->tags()->sync($updateable_tag_arr);
        } else {
          $updateable_product->tags()->detach();
        }

        //attach Amentities
        $amenities = $request->input('amenities');


        if (count($amenities) >= 1) {
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
          $updateable_product->amenities()->sync($updateable_amenities_arr);
        } else {
          $updateable_product->amenities()->detach();
        }

        $specifications = $request->input('specifications');
        if (count($specifications) >= 1) {
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
          $updateable_product->specifications()->sync($updateable_specifications_arr);
        } else {
          $updateable_product->specifications()->detach();
        }

        //removing unselected old images
        $updateable_images_arr = $request->input('updateable_images');
        $old_images_arr = $updateable_product->images;
        $new_image_arr = [];
        foreach ($old_images_arr as $old_img) {
          if (!in_array($old_img, $updateable_images_arr)) {
            if (File::exists("images/products/{$old_img}")) {
              File::delete("images/products/{$old_img}");
            }
          } else {
            $new_image_arr[] = $old_img;
          }
        }
        $updateable_product->images = $new_image_arr;
        $updateable_product->update();

        //adding more images if uploaded
        if ($request->hasFile('images')) {
          $images = $request->file('image');
          foreach ($images as $image) {
            $img_ext = $image->getClientOriginalExtension();
            $img_name = sprintf("P%s.%s", now()->format('YmdHis'), $img_ext);
            $img_path = public_path("images/products/{$updateable_product->id}");
            $image->move($img_path, $img_name);
          }
          $updateable_product->images = $new_image_arr;
          $updateable_product->update();
        }
        return response()->json('Product Update', Response::HTTP_CREATED);
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

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($product_id)
  {
    try {
      $product = Product::where('id', $product_id)->firstOrFail();
      $product->tags()->detach();
      $product->amenities()->detach();
      $product->specifications()->detach();
      if (File::isDirectory(public_path("images/products/{$product->id}"))) {
        File::deleteDirectory(public_path("images/products/{$product->id}"));
      }
      $product->delete();
      return response()->json('Product Deleted!', Response::HTTP_OK);
    } catch (ModelNotFoundException $mnt) {
      return response()->json('No Item Found', Response::HTTP_NOT_FOUND);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }


  /**
   * disabled specified resource .
   *
   * @param  int  $action,$id
   * @return \Illuminate\Http\Response
   */
  public function switchProductStatus($action = null, $id)
  {
    $product_action = function () use ($action) {
      $action_map = [0 => 'disabled', 1 => 'activated', 2 => 'reported'];
      if (in_array($action, array_keys($action_map))) {
        return $action_map[$action];
      } else {
        return null;
      }
    };
    if ($product_action() != null) {
      try {
        $product = Product::where('id', $id)->firstOrFail();
        $product->status = $product_action();
        if ($product_action() == 'reported') {
          $product->reported_at = now();
          $product->reported = true;
        }
        $product->updated();
        return response()->json([
          'success' => sprintf("Product %s!", $product_action()),
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
    } else {
      return response()->json([
        'error' => 'Invalid Action',
      ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }
}
