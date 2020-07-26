@extends('layouts.app')
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
  .view-ad-image{
    height:75vh;
    object-fit: cover;
  }
</style>
@endpush

<div class="uk-grid-collapse " uk-grid>
  <div class="uk-width-3-4@m uk-width-1-1@s uk-padding-remove  view-ad-page">
    <div class="uk-container  uk-padding-small ">
      <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-border-rounded">
        <h3 class=" uk-margin-remove-bottom"><b>{{$product->title}}</b></h3>
        <p class="uk-padding-small"> <a href="" class="uk-icon-button uk-margin-small-right"
            uk-icon="location" style="color: black; background-color:whitesmoke"></a> {{$product->state->name}},
          {{$product->city->name}}</p>
        <div>

          <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1"
            uk-slider="clsActivated: uk-transition-active; center: true;finite: true;">

            <ul class="uk-slider-items uk-grid">
              @foreach ($product->images as $img)
              <li class="uk-width-3-4">
                <div class="uk-panel">
                  <img class="view-ad-image" src="{{asset(sprintf('images/products/%s/%s',$product->id,$img))}}" alt="">
                </div>
              </li>
              @endforeach
            </ul>

            <a class="uk-position-center-left uk-position-small uk-hidden-hover" style="background:black" href="#" uk-slidenav-previous
              uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover" style="background:black" href="#" uk-slidenav-next
              uk-slider-item="next"></a>

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
          <p>{{$product->description}}
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
                  @foreach ($product->specifications as $specification)
                  <tr>
                    <td> {{$specification->name}}</td>
                    <td>{{$specification->value}} </td>
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
                    @foreach ($product->amenities as $amenity)
                  <tr>
                    <td> {{$amenity->name}}</td>
                    <td>{{$amenity->value}} </td>
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
          <img src="{{$product->user->avatar != null?URL::to(sprintf("images/users/profile/%s/%s",$product->user->id,$product->user->avatar)):asset("images/misc/default_avatar.png") }}"
            class="uk-border-circle profile_image" alt="ad user image">
          <p class="uk-margin-remove-bottom uk-text-boldicon">{{$product->user->get_full_name()}}</p>
          <div>
            <p>Agent</p>
            <a href="#" class="uk-button uk-button-small uk-border-rounded uk-margin-remove-bottom"
              style="background:red; color:white;">see all post</a>

          </div>
        </div>
        <div>
          <hr>
        </div>

        <div>
          <p class="uk-padding-small uk-margin-remove-bottom"><b>Contact Info</b></p>
        </div>

        <div>
          <p class="uk-padding-small uk-margin-remove uk-padding-remove-bottom"> <i class="uk-icon-button uk-margin-small-right"
              uk-icon="location" style="color: black; background-color:whitesmoke"></i> {{$product->user->state->name}},
            {{$product->user->city->name}}</p>
          <p class="uk-padding-small uk-margin-remove uk-padding-remove-bottom"> <i class="uk-icon-button uk-margin-small-right" uk-icon="mail"
              style="color: black; background-color:whitesmoke"></i> {{$product->user->email}}</a></p>
          <p class="uk-padding-small uk-margin-remove uk-padding-remove-bottom"> <i class="uk-icon-button uk-margin-small-right" uk-icon="phone"
              style="color: black; background-color:whitesmoke"></i> {{$product->user->phone}}</a></p>
        </div>

        <p class="uk-padding-small">
          <a href="#" class="uk-button uk-button-small  uk-margin-small-right uk-border-pill"
            style="color: white; background-color: orange"><b uk-icon="icon:mail;ratio:1;"></b>
            <b>Email</b></a>
          <a href="#" class="uk-button uk-button-small uk-margin-small-right uk-border-pill"
            style="color: white; background-color:#adf802"><b uk-icon="icon:whatsapp;ratio:1;"></b>
            <b> Whatsapp</b></a>

        </p>
      </div>

      <div class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-top view-ad-page-discription uk-border-rounded">
        <h4 class="uk-padding-small"><b>Tags</b></h4>
        <div>
          <hr>
        </div>

        <div class="uk-padding-small">
          @foreach ($product->tags as $tag)
          <a href="#" class="uk-label uk-label-warning">{{$tag->name}}</a>
          @endforeach
        </div>

      </div>

      <div class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-top view-ad-page-discription uk-border-rounded">
        <h4 class="uk-padding-small"><b>Safety Tips</b></h4>
        <div style="">
          <hr>
        </div>

        <ul class=" uk-padding-small " style="font-size: 0.7em; ">
          <li><b uk-icon="icon:warning; ration:0.5;" style="color:red;"></b> <b>Meet
              Seller at Public Place</b></li>
          <li><b uk-icon="icon:warning; ration:0.5;" style="color:red;"></b> <b>Check
              Property before you buy</b></li>
          <li><b uk-icon="icon:warning; ration:0.5;" style="color:red;"></b> <b>Pay
              only when given Property document</b></li>
          <li><b uk-icon="icon:warning; ration:0.5;" style="color:red;"></b> <b>check
              Property document validity before payment</b></li>
          <li><b uk-icon="icon:warning; ration:0.5;" style="color:red;"></b> <b>meet
              a legal rep</b></li>

        </ul>
      </div>

    </div>
  </div>
</div>
@endsection
