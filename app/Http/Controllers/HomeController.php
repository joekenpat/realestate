<?php

namespace App\Http\Controllers;

use App\Property;
use App\SiteConfig;
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
    return view('edit_profile',['user'=>$user]);
  }

  public function homepage()
  {
    $properties = Property::latest()->take(6)->get();
    $site_home_slider = SiteConfig::where('key', 'home_slider')->firstOrFail();
    return view('homepage',['slider_images'=> json_decode($site_home_slider->value),'properties'=>$properties]);
  }
}
