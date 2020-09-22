@extends('layouts.app')
@section('title', "Subcription Ended")
@section('content')
<div class="uk-padding-large-top uk-margin-padding-bottom grey lighten-5">
  <div class="uk-container " style="margin: auto; max-width: 700px; ">
    <div class="uk-card uk-card-default uk-card-body uk-width-1-1">
      <h3 class="uk-card-title uk-text-success"><b>Sorry To See You Go</b></h3>
      <p>{{$ex_sub_name}}, you have been successfully removed from the <b>Property Alert Subscription.</b> you can
        always Opt in
        again</p>
      <a class="uk-button " href="{{route('home')}}" uk-toggle
        style="background-color:#87ceeb;color:white; border-radius: 10px; margin-bottom: 20px "><b>Go Back
          Home</b></a>
    </div>
  </div>
</div>
@endsection
