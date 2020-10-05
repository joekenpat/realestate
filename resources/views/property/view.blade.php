@extends('layouts.app')
@section('title', " Viewing: $property->title")
@section('content')
<!-----dashboard start here----->
@push('style_top')
<style>
  body {
    background-color: whitesmoke;
  }

  a:link {
    color: black;
    text-decoration: none;
  }

  a:visited {
    color: black;
    background-color: whitesmoke;
  }

  a:active {
    color: blue;
    background-color: whitesmoke;
  }

  .dashboard-nav {
    font-size: 0.7em;
    padding-left: 20px;
  }

  .dashboard-tips {
    font-size: 0.9em;
    padding-left: 20px;
  }

  .dashboard-link {
    padding-left: 20px;
  }

  .dashboard-main {
    width: 70%;
    margin-top: 8%;
  }

  .dashboard-main2 {
    width: 50%;
  }

  .my-line {
    margin-top: -75px;
  }

  .tab-button {
    font-size: 0.7em;
    background-color: #9966cc;
    color: white;
    text-transform: capitalize;
    font-weight: bold;
    padding: 1px;
    margin: -100px;
    width: 100px;
  }

  .my-button-padding {
    padding: 2px;
  }

  /* .formatForButton{
    background-color:#adf802;
} */
  /* span {
    display: none;
  } */

  @media (max-width: 740px) {
    .dashboard-main {
      width: 100%;
      margin-top: 25%;
    }

    .dashboard-main2 {
      width: 100%;
    }

    .my-margin {
      margin-top: 2%;
    }

    .my-container {
      padding-left: 30px !important;
    }

    .tab-button {
      font-size: 0.7em;
      background-color: #9966cc;
      color: white;
      text-transform: capitalize;
      font-weight: bold;
      padding: 5px;
      margin: -30px;

    }

    .my-button-padding-small {
      padding-left: 30px;
    }
  }


  body {
    background-color: whitesmoke;
  }

  ul {
    list-style-type: none;
  }

  a:link {
    color: black;
    text-decoration: none;
  }

  a:visited {
    color: black;
    background-color: whitesmoke;
  }

  a:active {
    color: blue;
    background-color: whitesmoke;
  }

  .dashboard-nav {
    font-size: 0.7em;
    padding-left: 20px;
  }

  .dashboard-tips {
    font-size: 0.9em;
    padding-left: 20px;
  }

  .dashboard-link {
    padding-left: 20px;
  }

  .dashboard-main {
    width: 70%;
    margin-top: 8%;
  }

  .dashboard-main2 {
    width: 50%;
  }

  .my-line {
    margin-top: -75px;
  }

  .tab-button {
    font-size: 0.7em;
    background-color: #9966cc;
    color: white;
    text-transform: capitalize;
    font-weight: bold;
    padding: 1px;
    margin: -100px;
    width: 100px;
  }

  .my-button-padding {
    padding: 2px;
  }

  /* .formatForButton{
    background-color:#adf802;
} */
  /* span {
    display: none;
  } */

  @media (max-width: 740px) {
    .dashboard-main {
      width: 100%;
      margin-top: 25%;
    }

    .dashboard-main2 {
      width: 100%;
    }

    .my-margin {
      margin-top: 2%;
    }

    .my-container {
      padding-left: 30px !important;
    }

    .tab-button {
      font-size: 0.7em;
      background-color: #9966cc;
      color: white;
      text-transform: capitalize;
      font-weight: bold;
      padding: 5px;
      margin: -30px;

    }

    .my-button-padding-small {
      padding-left: 30px;
    }
  }

  .profile_image {
    width: 150px;
    height: 150px;
    object-fit: cover;
  }

  .view-ad-image {
    object-fit: cover;
    max-height: 500px;
  }
</style>
@endpush

<div class="uk-grid-collapse " uk-grid>
  <div class="uk-width-3-4@m uk-width-1-1@s uk-padding-remove  view-ad-page">
    <div class="uk-container  uk-padding-small ">
      <div class="uk-card uk-card-default uk-padding-remove uk-border-rounded">
        <div class="uk-card-header">
          <h3 class=" uk-margin-remove-bottom"><b>{{$property->title}}</b></h3>
          <h4 class="uk-text-bold uk-margin-remove-vertical uk-margin-auto-left">
            &#8358;{{number_format($property->price)}}</h4>
        </div>
        <div class="uk-padding-small uk-flex uk-flex-between">
          <div>
            <span class="uk-icon-button uk-margin-small-right" uk-icon="location"
              style="color: black; background-color:whitesmoke"></span><span> {{$property->state->name}},
              {{$property->city->name}}</span>

            <span></div>
          {{-- <a href="#" class="uk-button uk-button-default uk-button-small uk-border-rounded" style="color:#f00"
              uk-icon="icon: heart">
              Like
            </a> --}}
          </span>
        </div>
        <div>

          <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1"
            uk-slideshow="clsActivated: uk-transition-active; center: true;autoplay:true;max-height: 500">

            <ul class="uk-slideshow-items">
              @foreach ($property->images as $img)
              <li class="">
                <div class="uk-panel">
                  @if(count($property->images))
                  <img class="view-ad-image uk-width-1-1"
                    src="{{asset(sprintf('images/properties/%s/%s',$property->id,$img))}}" alt="">
                  @else
                  <img class="view-ad-image uk-width-1-1" src="{{asset(sprintf('images/misc/no-image.jpg'))}}" alt="">
                  @endif
                </div>
              </li>
              @endforeach
            </ul>

            <a class="uk-position-center-left uk-position-small uk-hidden-hover" style="background:black" href="#"
              uk-slidenav-previous uk-slideshow-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover" style="background:black" href="#"
              uk-slidenav-next uk-slideshow-item="next"></a>

          </div>


        </div>
      </div>
    </div>


    <div class="uk-container  uk-padding-small  view-ad-page-discription">
      <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-padding-remove uk-border-rounded">
        <h4 class="uk-padding-small"><b>Description</b></h4>
        <div style="margin-top: -30px">
          <hr>
        </div>
        <div class="uk-padding-small">
          <p>{!! $property->description !!}
          </p>


          <div uk-grid>
            <div class="uk-width-1-2@m uk-width-1-1@s">
              <p><b>Specification</b></p>

              <!-----table start here-------->

              <table class="uk-table uk-table-hover uk-table-responsive uk-table-divider my-table">
                <thead>
                  <tr>
                    <th><b>NAME</b></th>
                    <th><b>VALUE</b></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($property->specifications as $specification)
                  <tr>
                    <td> {{$specification->name}}</td>
                    <td>{{$specification->pivot->value}} </td>
                  </tr>

                  @endforeach
                </tbody>
              </table>

              <!-----table end here-------->
            </div>
            <div class="uk-width-1-2@m uk-width-1-1@m">
              <p><b>Amenities</b></p>

              <!-----table start here-------->

              <table class="uk-table uk-table-hover uk-table-responsive uk-table-divider my-table">
                <thead>
                  <tr>
                    <th><b>NAME</b></th>
                    <th><b>VALUE</b></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    @foreach ($property->amenities as $amenity)
                  <tr>
                    <td> {{$amenity->name}}</td>
                    <td>{{$amenity->pivot->value}} </td>
                  </tr>

                  @endforeach
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!----table end here-->

        </div>
      </div>

    </div>
  </div>
  <div class="uk-width-1-4@m uk-width-1-1@s  uk-padding-remove view-ad-page-contact ">
    <div class="uk-container uk-padding-small ">
      <div class="uk-card uk-card-default uk-card-body  uk-padding-remove uk-border-rounded">
        <h4 class="uk-padding-small uk-margin-remove-bottom"><b>Posted By</b></h4>
        <div>
          <hr>
        </div>
        <div class="uk-padding-small uk-text-center">
          <img
            src="{{$property->user->avatar != null?URL::to(sprintf("images/users/profile/%s/%s",$property->user->id,$property->user->avatar)):asset("images/misc/default_avatar.png") }}"
            class="uk-border-circle profile_image" alt="ad user image">
          <p class="uk-margin-remove-bottom uk-text-boldicon">{{$property->user->get_full_name()}}</p>
          <div>
            <p class="uk-label blue darken-2 uk-text-bold uk-border-rounded" style="padding:3px 10px;">
              @if($property->user->role == 'agent')
              <span uk-icon="icon:home;ratio:.9"></span> <span
                class=" uk-divider-vertical uk-margin-small-right uk-margin-small-left"></span> Realtor
              @elseif($property->user->role == 'user')
              <span uk-icon="icon:user;ratio:.9"></span> <span
                class=" uk-divider-vertical uk-margin-small-right uk-margin-small-left"></span> Member
              @else
              <span uk-icon="icon:nut;ratio:.9"></span> <span
                class=" uk-divider-vertical uk-margin-small-right uk-margin-small-left"></span> Admin
              @endif

            </p>
            {{-- <a href="#" class="uk-button uk-button-small uk-border-rounded uk-margin-remove-bottom"
              style="background:red; color:white;">see all post</a> --}}

          </div>
        </div>
        <div>
          <hr>
        </div>

        <div>
          <p class="uk-padding-small uk-margin-remove-bottom"><b>Contact Info</b></p>
        </div>

        <div>
          <p class="uk-padding-small uk-margin-remove uk-padding-remove-bottom"> <i
              class="uk-icon-button uk-margin-small-right" uk-icon="location"
              style="color: black; background-color:whitesmoke"></i>
            {{$property->user->state?$property->user->state->name:"N/A"}},
            {{$property->user->city?$property->user->city->name:"N/A"}}</p>
          <p class="uk-padding-small uk-margin-remove uk-padding-remove-bottom"> <i
              class="uk-icon-button uk-margin-small-right" uk-icon="mail"
              style="color: black; background-color:whitesmoke"></i> {{$property->user->email}}</p>
          <p class="uk-padding-small uk-margin-remove uk-padding-remove-bottom"> <a
              href="tel:{{$property->user->phone}}"> <i class="uk-icon-button uk-margin-small-right" uk-icon="receiver"
                style="color: black"></i> <a href="tel:{{$property->user->phone}}"
                class="uk-button uk-button-small blue accent-2  uk-margin-small-right uk-border-pill"
                style="color: white;">
                <b>{{$property->user->phone}}</b></a></a></p>
        </div>

        <p class="uk-padding-small">
          <a href="mailto:{{$property->user->email}}?subject={{str_replace(' ','%20',"Information needed for product: {$property->title}")}}&body={{str_replace(' ','%20',sprintf("Hi, I'll like to find out more about this property: %s", route('view_property',['property_slug'=>$property->slug])))}}"
            class="uk-button uk-button-small  uk-margin-small-right uk-border-pill"
            style="color: white; background-color: orange"><b uk-icon="icon:mail;ratio:1;"></b>
            <b>Email</b></a>
          <a href="https://wa.me/234{{substr($property->user->phone,1)}}?text={{str_replace(' ','%20',sprintf("Hi, I'll like to find out more about this property: %s", route('view_property',['property_slug'=>$property->slug])))}}"
            class="uk-button uk-button-small uk-margin-small-right uk-border-pill"
            style="color: white; background-color:#4caf50"><b uk-icon="icon:whatsapp;ratio:1;"></b>
            <b> Whatsapp</b></a>

        </p>
      </div>

      <div
        class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-top view-ad-page-discription uk-border-rounded">
        <h4 class="uk-padding-small uk-margin-remove-bottom"><b>Tags</b></h4>
        <hr class="uk-margin-remove">

        <div class="uk-padding-small">
          @foreach ($property->tags as $tag)
          <a href="#" class="uk-label uk-label-warning">#{{$tag->name}}</a>
          @endforeach
        </div>

      </div>
      @include('layouts.safety_tip_card')
    </div>
  </div>
</div>
@endsection
