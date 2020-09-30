@extends('layouts.app')
@section('title', 'Post Property')
@section('content')
<div class="uk-container uk-margin-large-top uk-margin-large-bottom">
  <p class="uk-text-large uk-text-center">BOOST OR FEATURE YOUR PROPERTIES TO REACH A WIDER AUDIENCE AROUND THE WORLD IN A SHORT TIME.</p>
  <div uk-grid class="uk-margin-top">
    <div class="uk-width-1-3@m uk-width-1-1@s">
      <div class="uk-card uk-card-default uk-card-body grey lighten-5">
        <h3 class="uk-card-title uk-text-danger uk-text-center uk-padding-remove uk-text-bold uk-margin-remove ">
          FREE
        </h3>
        <hr class="uk-divider-icon">
        <P class="uk-text-center uk-text-bold uk-padding-remove">DURATION</P>
        <p class="uk-text-center uk-padding-remove">{{$span->free}} days</p>
        <hr>
        <P class="uk-text-center uk-text-bold uk-padding-remove">PRICE</P>
        <p class="uk-text-center uk-padding-remove uk-margin-remove">&#8358 0.00</p>
        <hr>
      </div>
    </div>
    <div class="uk-width-1-3@m uk-width-1-1@s">
      <div class="uk-card uk-card-default uk-card-body grey lighten-5">
        <h3 class="uk-card-title uk-text-warning uk-text-center uk-padding-remove uk-text-bold uk-margin-remove ">
          DISTRESS
        </h3>
        <hr class="uk-divider-icon">
        <P class="uk-text-center uk-text-bold uk-padding-remove">DURATION</P>
        <p class="uk-text-center uk-padding-remove">{{$span->distress}} days</p>
        <hr>
        <P class="uk-text-center uk-text-bold uk-padding-remove">PRICE</P>
        <p class="uk-text-center uk-padding-remove uk-margin-remove">&#8358 {{$fee->distress}}</p>
        <hr>
      </div>
    </div>
    <div class="uk-width-1-3@m uk-width-1-1@s">
      <div class="uk-card uk-card-default uk-card-body grey lighten-5">
        <h3 class="uk-card-title uk-text-success uk-text-center uk-padding-remove uk-text-bold uk-margin-remove ">
          FEATURED
        </h3>
        <hr class="uk-divider-icon">
        <P class="uk-text-center uk-text-bold uk-padding-remove">DURATION</P>
        <p class="uk-text-center uk-padding-remove">{{$span->featured}} days</p>
        <hr>
        <P class="uk-text-center uk-text-bold uk-padding-remove">PRICE</P>
        <p class="uk-text-center uk-padding-remove uk-margin-remove">&#8358 {{$fee->featured}}</p>
        <hr>
      </div>
    </div>
  </div>
</div>
<!-----userdashboard end here----->
@endsection
@push('scripts_bottom')
@endpush
