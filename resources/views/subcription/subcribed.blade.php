@extends('layouts.app')
@section('title', "Subcription Started")
@section('content')
<div class="uk-padding-large-top uk-padding-large-bottom grey lighten-5">
  <div class="uk-container " style="margin: auto; max-width: 700px; ">
    <div class="uk-card uk-card-default uk-card-body uk-width-1-1">
      <h3 class="uk-card-title uk-text-success"><b>Thanks For Subscribing</b></h3>
      <p>{{$sub_name}}, you have sucessfully signed up to receive <b>Property Alert.</b> Don't worry we won't spam
        you</p>
      <a class="uk-button " href="{{route('home')}}" uk-toggle
        style="background-color:#87ceeb;color:white; border-radius: 10px; margin-bottom: 20px "><b>Go Back
          Home</b></a>
    </div>
  </div>
</div>
@endsection
