<?php

namespace App\Http\Controllers;

use App\Subscriber;
use App\Subscription;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'subscription_name' => 'required|string|max:254|min:3',
      'subscription_email' => 'required|email|unique:subscribers,email',
      'subscription_phone' => 'numeric|unique:subscribers,phone',
      'subscription_category' => 'required|exists:categories,id',
      'subscription_subcategory' => 'required|exists:subcategories,id',
      'subscription_state' => 'sometimes|exists:states,id',
    ]);

    $new_sub_user = new Subscriber();
    $new_sub_user->name = $request->subscription_name;
    $new_sub_user->email = $request->subscription_email;
    $new_sub_user->phone = $request->subscription_phone;
    $new_sub_user->save();
    $new_sub_user->refresh();

    $new_sub = new Subscription();
    $new_sub->category_id = $request->subscription_category;
    $new_sub->subcategory_id = $request->subscription_subcategory;
    $new_sub->state_id = $request->subscription_state;
    $new_sub->subscriber_id = $new_sub_user->id;
    $new_sub->save();
    return view('subcription.subcribed', ['sub_name' => $new_sub->name]);
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Subscriber  $subscriber
   * @return \Illuminate\Http\Response
   */
  public function destroy($subscriber_id)
  {
    $subscriber = Subscriber::where('id', $subscriber_id)->firstOrFail();
    $subscriber->subscriptions()->delete();
    $subscriber->delete();
    return view('subcription.unsubscribed', ['ex_sub_name' => $subscriber->name]);
  }
}
