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
</style>
@endpush
<div class="uk-grid-collapse" uk-grid>
  <div class="uk-visible@m uk-width-1-4 uk-padding-small">
    <div class="uk-card uk-card-default uk-margin uk-border-rounded uk-padding-remove uk-overflow-auto"
     style="background:white;">
      <div class="uk-card-body uk-padding-remove">
        <div class="uk-text-center">
          <img src="{{Auth()->user()->avatar != null?URL::to(sprintf("images/users/profile/%s/%s",Auth()->user()->id,Auth()->user()->avatar)):asset("images/misc/default_avatar.png") }}"
            class="uk-border-circle uk-margin-top profile_image" alt="Your Profile image">
        </div>
        <p class="uk-text-center uk-margin-remove-bottom uk-margin-small-top uk-text-capitalize">
          <b>{{Auth()->user()->get_full_name()}}</b></p>
        <p class="uk-text-center uk-margin-remove uk-text-muted uk-text-small">{{Auth()->user()->email}}</p>
        <hr class="uk-margin-remove">
        <ul class="uk-list uk-list-divider uk-padding-remove-left uk-margin-remove-top">
          <li class="" style="padding: .4em .1em .2em .1em"><a href="{{route('edit_profile')}}"><i
                class="mdi  mdi-account" style="color:#adf802; "></i><b class="dashboard-link">Edit
                Profile</b></a></li>
          <li class="" style="padding: .4em .1em .2em .1em"><a href="{{route('user_list_product')}}"><i
                class="mdi  mdi-diamond-stone" style="color:#adf802;"></i><b class="dashboard-link">My Ads</b></a>
          </li>
          <li class="" style="padding: .4em .1em .2em .1em"><a href="#"><i class="mdi  mdi-heart"
                style="color:#adf802; "></i><b class="dashboard-link">My
                Favourite</b></a></li>
          <li class="" style="padding: .4em .1em .2em .1em"><a href="#"><i class="mdi  mdi-credit-card-outline"
                style="color:#adf802; "></i><b class="dashboard-link">Payment</b></a></li>
          <li class="" style="padding: .4em .1em .2em .1em"><a href="{{route('user_create_product')}}"><i
                class="mdi  mdi-telegram" style="color:#adf802; "></i><b class="dashboard-link">Post Ads
              </b></a></li>
          <li class="" style="padding: .4em .1em .4em .1em"><a href="#"><i class="mdi  mdi-power-settings"
                style="color:#adf802; "></i><b class="dashboard-link">Log
                Out</b></a></li>
        </ul>
      </div>
    </div>
  </div>
  <!-----nav links for desktop end here----->

  <!-----poast ads start here----->
  <div class="uk-width-1-1 uk-width-3-4@m uk-padding-small">
    <Post-Ad-Form form_action="{{route('api_save_new_product')}}" :categories_data="{{$categories_data}}">
      <!-----post ads end here----->

      <div uk-grid>

        <!------benefits tips start here---->
        <div class="uk-width-1-2@m uk-width-1-1@s dashboard-main2 my-margin">
          <div class="uk-container uk-padding-remove uk-margin my-container">
            <div class="uk-card uk-card-default uk-margin-small uk-border-rounded">
              <div class="uk-card-header">
                <h5 class=""><b style="color: #87ceeb">Benefits Of Paid Ad</b></h5>
              </div>
              <div class="uk-card-body uk-padding-small">
                <ul class="uk-padding-remove uk-margin-remove">
                  <li class=" dashboard-tips"><i class="mdi  mdi-arrow-right-bold-circle" style="color:#adf802; "></i><b
                      class="dashboard-tips">
                      Meet Seller at Public Place</b></li>
                  <li class=" dashboard-tips"><i class="mdi  mdi-arrow-right-bold-circle" style="color:#adf802; "></i><b
                      class="dashboard-tips">
                      Check Property brfor you buy</b></li>
                  <li class=" dashboard-tips"><i class="mdi  mdi-arrow-right-bold-circle" style="color:#adf802; "></i><b
                      class="dashboard-tips">
                      Pay only when given Property document</b></li>
                  <li class=" dashboard-tips uk-margin-small"><a href="" class="dashboard-tips ">
                      <b> view more...</b></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!------benefits tips end here---->

        <!------safety tips start here---->
        <div class="uk-width-1-2@m uk-width-1-1@s dashboard-main2 my-margin">
          <div class="uk-container uk-padding-remove uk-margin my-container">
            <div class="uk-card uk-card-default uk-margin-small uk-border-rounded">
              <div class="uk-card-header">
                <h5 class=""><b style="color: #87ceeb">Safety Tips</b></h5>
              </div>
              <div class="uk-card-body uk-padding-small">
                <ul class="uk-padding-remove uk-margin-remove">
                  <li class=" dashboard-tips"><i class="mdi  mdi-arrow-right-bold-circle" style="color:#adf802; "></i><b
                      class="dashboard-tips">
                      Meet Seller at Public Place</b></li>
                  <li class=" dashboard-tips"><i class="mdi  mdi-arrow-right-bold-circle" style="color:#adf802; "></i><b
                      class="dashboard-tips">
                      Check Property before you buy</b></li>
                  <li class=" dashboard-tips"><i class="mdi  mdi-arrow-right-bold-circle" style="color:#adf802; "></i><b
                      class="dashboard-tips">
                      Pay only when given Property document</b></li>
                  <li class=" dashboard-tips uk-margin-small"><a href="" class="dashboard-tips ">
                      <b> view more...</b></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!------safety tips end here---->
      </div>
  </div>


</div>

<!-----userdashboard end here----->
@endsection
