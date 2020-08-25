<?php

namespace App\Http\Controllers\API;

use App\City;
use App\Http\Controllers\Controller;
use App\Property;
use App\Subcategory;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {

      $subcategories = subcategory::with('category')->paginate(10);
      $success['data'] = $subcategories;
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
      'category_id' => 'required|numeric',
    ]);
    try {
      $new_subcat = subcategory::firstOrCreate([
        'name' => $request->input('name'),
        'category_id' => $request->input('name'),
      ]);
      $success['data'] = $new_subcat;
      return response()->json([
        'success' => $success,
      ], Response::HTTP_OK);
    } catch (Exception $e) {
      return response()->json([
        'error' => $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Subcategory  $subcategory
   * @return \Illuminate\Http\Response
   */
  public function show(Subcategory $subcategory)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Subcategory  $subcategory
   * @return \Illuminate\Http\Response
   */
  public function edit(Subcategory $subcategory)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Subcategory  $subcategory
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'name' => 'required|string|',
      'category_id' => 'required|numeric|',
    ]);
    try {
      $sub_cat = Subcategory::where('id', $id)->firstOrFail();
      $sub_cat->name = $request->input('name');
      $sub_cat->category_id = $request->input('category_id');
      $sub_cat->update();
      $success['data'] = $sub_cat;
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
   * @param  \App\Subcategory  $subcategory
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {
      $sub_cat = Subcategory::where('id', $id)->firstOrFail();
      $associated_pro = Property::where('category_id', $sub_cat->id)->count();
      Property::where('subcategory_id', $sub_cat->id)->update(['subcategory_id' => null]);
      $sub_cat->delete();
      return response()->json([
        'success' => "Sub-category Deleted! You have {$associated_pro} Uncategorized Items",
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


  public function list_city_for_state_code($state_code)
  {
    try {
      $cities = City::select('id', 'name')->where('state_code', $state_code)->get();
      return response()->json($cities, Response::HTTP_OK);
    } catch (ModelNotFoundException $mnt) {
      return response()->json('No city Found', Response::HTTP_NOT_FOUND);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function find_city_in_state($findable, $state_code)
  {
    try {
      $cities = City::select('id', 'name')->where('state_code', $state_code)->where('name', 'LIKE', "%{$findable}%")->limit(10)->get();
      return response()->json([
        'success' => $cities,
      ], Response::HTTP_OK);
    } catch (ModelNotFoundException $mnt) {
      return response()->json([
        'error' => 'No city Found',
      ], Response::HTTP_NOT_FOUND);
    } catch (\Exception $e) {
      return response()->json([
        'error' => $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
