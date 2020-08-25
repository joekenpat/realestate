<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use App\Property;
use App\Subcategory;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\support\str;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {
      $categories = Category::with('subcategories')->get();
      return response()->json($categories, Response::HTTP_OK);
    } catch (ModelNotFoundException $mnt) {
      return response()->json('No Item Found', Response::HTTP_NOT_FOUND);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|string|',
      'image' => 'required|file|image|mimes:jpeg,png,gif,jpg|max:2048',
    ], [
      'image:required' => 'All category Must have an Image'
    ]);
    try {
      $new_cat = Category::firstOrNew([
        'name' => $request->input('name')
      ], [
        'slug'=> Str::slug( $request->input('name')),
        'image' => null,
      ]);

      //adding images
      $image = $request->file('image');
      $img_ext = $image->getClientOriginalExtension();
      $img_name = sprintf("CICN_%s.%s", $request->input('name'), $img_ext);
      $image->storeAs("images/categories", $img_name);
      $new_cat->images = $img_name;
      $new_cat->save();
    } catch (Exception $e) {
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function show(Category $category)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function edit(Category $category)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'name' => 'required|string|',
      'image' => 'required|file|image|mimes:jpeg,png,gif,jpg|max:2048',
    ], [
      'image:required' => 'All category Must have an Image'
    ]);
    try {
      $cat = Category::where('id', $id)->firstOrFail();
      $cat->name = $request->input('name');
      $cat->slug = Str::slug( $request->input('name'));
      $cat->image = null;
      $cat->update();
      $success['data'] = $cat;
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
   * Remove the specified resource from storage.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {
      $cat = Category::where('id', $id)->firstOrFail();
      Subcategory::where('category_id', $cat->id)->delete(['category_id' => null]);
      $associated_pro = Property::where('category_id', $cat->id)->count();
      Property::where('category_id', $cat->id)->update(['category_id' => null, 'subcategory_id' => null]);
      $cat->delete();
      return response()->json([
        'success' => "Category Deleted! You have {$associated_pro} Uncategorized Items",
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
}
