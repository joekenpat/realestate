<?php

namespace App\Http\Controllers;

use App\Product;
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
      $min_val = Product::where('status','active')->min('price');
      $max_val = Product::where('status','active')->max('price');
      $ad_min_val = $min_val?:0;
      $ad_max_val = $max_val?:999999999;
        return view('home',['min_val'=>$ad_min_val,'max_val'=>$ad_max_val]);
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
    return view('edit_profile',['user'=>$user]);
  }
}
