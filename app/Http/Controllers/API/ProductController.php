<?php

namespace App\Http\Controllers\API;

use App\Amenity;
use App\Http\Controllers\Controller;
use App\Product;
use App\Specification;
use App\Tag;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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

    $status = $request->filled('status') ? $request->status : 'open';
    $sort = $request->filled('sort') ? $request->sort : 'new';
    $min_price = $request->filled('min_price') ? $request->min_price : 0;
    $max_price = $request->filled('max_price') ? $request->max_price : 99999999999999;
    $expired = $request->filled('expired') ? $request->expired : false;
    $reported = $request->filled('reported') ? $request->reported : false;


    $item_status = function () use ($status) {
      if (in_array($status, ['open', 'closed'])) {
        return $status;
      } else {
        return 'open';
      }
    };
    $item_sort_type = function () use ($sort) {
      $sort_type = ['old' => "asc", 'new' => 'desc'];
      if (in_array($sort, ['old', 'new'])) {
        return $sort_type[$sort];
      } else {
        return $sort_type['new'];
      }
    };
    $item_expired = function () use ($expired) {
      if (in_array($expired, [true, false, 1, 0])) {
        return $expired;
      } else {
        return false;
      }
    };
    $item_reported = function () use ($reported) {
      if (in_array($reported, [true, false, 1, 0])) {
        return $reported;
      } else {
        return false;
      }
    };

    $item_min_price = $min_price;
    $item_max_price = $max_price;

    if (Auth()->user()->isUser()) {
      try {
        $products = Product::with('user:first_name,last_name,username,phone,email,avatar,verification_status')
          ->with('tags:name')
          ->with('amenities:name,value')
          ->with('specifications:name,value')
          ->where('status', $item_status())
          ->where('expired', $item_expired())
          ->where('reported', $item_reported())
          ->whereBetween('price', [$item_min_price, $item_max_price])
          ->orderBy('created_at', $item_sort_type())
          ->paginate(12);
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
    } elseif (Auth()->user()->isAgent()) {
      try {
        $products = $products = Product::with('user:first_name,last_name,username,phone,email,avatar,verification_status')
          ->with('tags:name')
          ->with('amenities:name,value')
          ->with('specifications:name,value')
          ->where('status', $item_status)
          ->where('expired', $item_expired)
          ->where('reported', $item_reported)
          ->whereBetween('price', [$item_min_price, $item_max_price])
          ->orderBy('created_at', $item_sort_type)
          ->paginate(12);
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
    } elseif (Auth()->user()->isAdmin()) {
      try {
        $products = $products = Product::with('user:first_name,last_name,username,phone,email,avatar,verification_status')
          ->with('tags:name')
          ->with('amenities:name,value')
          ->with('specifications:name,value')
          ->where('status', $item_status)
          ->where('expired', $item_expired)
          ->where('reported', $item_reported)
          ->whereBetween('price', [$item_min_price, $item_max_price])
          ->orderBy('created_at', $item_sort_type)
          ->paginate(12);
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
      'category_id' => 'required|numeric|',
      'subcategory_id' => 'required|numeric|',
      'country_id' => 'required|numeric|exists:countries,id',
      'state_id' => 'required|numeric|exists:states,id',
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
      $new_product->country_id = $request->input('country_id');
      $new_product->state_id = $request->input('state_id');
      $new_product->city_id = $request->input('city_id');
      $new_product->phone = $request->input('phone');
      $new_product->list_as = $request->input('list_as');
      $new_product->plan = $request->input('plan');
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
        $images = $request->file('image');
        foreach ($images as $image) {
          $img_ext = $image->getClientOriginalExtension();
          $img_name = sprintf("PIMG_%s.%s", now()->format('Y-m-d H:i:s.u'), $img_ext);
          $image_url[] = $image->storeAs("images/products/{$new_product->id}", $img_name);
        }
        $new_product->images = $image_url;
        $new_product->update();
      }
      $new_product = Product::with('user:first_name,last_name,username,phone,email,avatar,verification_status')
        ->with('tags:name')
        ->with('amenities:name,value')
        ->with('specifications:name,value')
        ->where('id', $new_product->id)
        ->firstOrFail();
      $success['data'] = $new_product;
      return response()->json([
        'success' => $success
      ], Response::HTTP_OK);
    } catch (\Exception $e) {
      $message = sprintf("message: %s. Error File: %s. Error Line: %s", $e->getMessage(), $e->getFile(), $e->getLine());
      return response()->json([
        'error' => $message,
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
        'country_id' => 'required|numeric|exists:countries,id',
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
        $updateable_product->country_id = $request->input('country_id');
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
            if (Storage::exists("images/products/{$old_img}")) {
              Storage::delete("images/products/{$old_img}");
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
            $img_name = sprintf("PIMG_%s.%s", now()->format('Y-m-d H:i:s.u'), $img_ext);
            $new_image_arr[] = $image->storeAs("images/products/{$updateable_product->id}", $img_name);
          }
          $updateable_product->images = $new_image_arr;
          $updateable_product->update();
        }
        $updateable_product = Product::with('user:first_name,last_name,username,phone,email,avatar,verification_status')
          ->with('tags:name')
          ->with('amenities:name,value')
          ->with('specifications:name,value')
          ->where('id', $updateable_product->id)
          ->firstOrFail();
        $success['data'] = $updateable_product;
        return response()->json([
          'success' => $success
        ], Response::HTTP_OK);
      } catch (\Exception $e) {
        $message = sprintf("message: %s. Error File: %s. Error Line: %s", $e->getMessage(), $e->getFile(), $e->getLine());
        return response()->json([
          'error' => $message,
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    } else {
      return response()->json([
        'error' => 'No Item Found to update',
      ], Response::HTTP_NOT_FOUND);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {
      $product = Product::where('id', $id)->firstOrFail();
      $product->tags()->detach();
      $product->amenities()->detach();
      $product->specifications()->detach();
      // if(Storage::isDirectory("images/products/{$product->id}")){
      //   Storage::deleteDirectory("images/products/{$product->id}");
      // }
      $product->delete();
      return response()->json([
        'success' => 'Product Deleted!',
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
