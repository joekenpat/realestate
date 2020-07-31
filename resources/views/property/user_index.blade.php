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
  .property_title {
    width: 235px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

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
          <img
            src="{{Auth()->user()->avatar != null?URL::to(sprintf("images/users/profile/%s/%s",Auth()->user()->id,Auth()->user()->avatar)):asset("images/misc/default_avatar.png") }}"
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
          <li class="" style="padding: .4em .1em .2em .1em"><a href="{{route('user_list_property')}}"><i
                class="mdi  mdi-diamond-stone" style="color:#adf802;"></i><b class="dashboard-link">My Ads</b></a>
          </li>
          <li class="" style="padding: .4em .1em .2em .1em"><a href="#"><i class="mdi  mdi-heart"
                style="color:#adf802; "></i><b class="dashboard-link">My
                Favourite</b></a></li>
          <li class="" style="padding: .4em .1em .2em .1em"><a href="#"><i class="mdi  mdi-credit-card-outline"
                style="color:#adf802; "></i><b class="dashboard-link">Payment</b></a></li>
          <li class="" style="padding: .4em .1em .2em .1em"><a href="{{route('user_create_property')}}"><i
                class="mdi  mdi-telegram" style="color:#adf802; "></i><b class="dashboard-link">Post Ads
              </b></a></li>
          <li class="" style="padding: .4em .1em .4em .1em"><a href="#"><i class="mdi  mdi-power-settings"
                style="color:#adf802; "></i><b class="dashboard-link">Log
                Out</b></a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="uk-width-1-1 uk-width-3-4@m uk-padding-small">
    <div class="uk-container uk-padding-remove uk-margin">
      <div class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-small uk-border-rounded">
        <h5 class="uk-padding-small"><b style="color: #87ceeb">My Ads</b></h5>
        <hr class="uk-margin-remove" />
        <!---tab button start here---->
        <div uk-grid
          class="uk-text-center uk-child-width-1-1 uk-child-width-1-2@s uk-padding-small uk-grid-small uk-flex uk-flex-center">
          <div class="uk-flex-center">
            <a href="{{request()->fullUrlWithQuery(['status'=>'all'])}}"
              class="uk-button uk-button-small uk-button-default">
              All
            </a>
            <a href="{{request()->fullUrlWithQuery(['status'=>'pending'])}}"
              class="uk-button uk-button-small uk-button-default">
              Pending
            </a>
            <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}"
              class="uk-button uk-button-small uk-button-default">
              Active
            </a>
            <a href="{{request()->fullUrlWithQuery(['status'=>'expired'])}}"
              class="uk-button uk-button-small uk-button-default">
              Expired
            </a>
          </div>
          <div class="uk-button-group uk-flex-center">
            <a href="{{request()->fullUrlWithQuery(['plan'=>'all'])}}"
              class="uk-button uk-button-small uk-button-default">
              All
            </a>
            <a href="{{request()->fullUrlWithQuery(['plan'=>'free'])}}"
              class="uk-button uk-button-small uk-button-default">
              Free
            </a>
            <a href="{{request()->fullUrlWithQuery(['plan'=>'distress'])}}"
              class="uk-button uk-button-small uk-button-default">
              Distress
            </a>
            <a href="{{request()->fullUrlWithQuery(['plan'=>'featured'])}}"
              class="uk-button uk-button-small uk-button-default">
              Featured
            </a>
          </div>
        </div>
        <hr class="uk-margin-remove" />
        <!---tab button end here---->
        <!-----table start here-------->

        <table class="uk-table uk-table-small uk-table-responsive uk-table-divider uk-margin-remove-top">
          <thead>
            <tr>
              <th><b>Image</b></th>
              <th><b>Item</b></th>
              <th><b>Category</b></th>
              <th><b>Price</b></th>
              <th><b>Status</b></th>
              <th><b>Action</b></th>
            </tr>
          </thead>
          <tbody>
            @if($properties->isNotEmpty())
            @foreach ($properties as $property)
            <tr id="{{"item_{$property->id}"}}">
              <td>
                <img src="{{asset("/images/properties/{$property->id}/{$property->images[0]}")}}"
                  style="height: 80px; width: 100px" />
              </td>
              <td class="uk-table-link">
                <a href="{{route('view_property',['property_id'=>$property->id])}}" class="uk-link-reset">
                  <ul class="uk-margin-remove-bottom uk-padding-remove-left">
                    <li class="property_title">
                      {{ $property->title }}
                    </li>
                    <li>
                      <time datetime="{{$property->created_at}}">{{
                        $property->created_at
                      }}</time>
                    </li>
                    <li>
                      <span class="uk-label uk-label-success">{{
                        $property->list_as
                      }}</span>
                    </li>
                  </ul>
                </a>
              </td>
              <td>
                <a href="#">{{ $property->category->name }}</a> &gt;
                <a href="#">{{ $property->subcategory->name }}</a>
              </td>
              <td>N{{ number_format($property->price) }}</td>
              <td>
                <span class="uk-label uk-label-warning">{{
                  $property->status
                }}</span>
              </td>
              <td>
                <!-- <a
                  :href="`${base_url}/user/property/upgrade/${property.id}`"
                  style="color:orange"
                  uk-tooltip="Upgrade Property"
                  class="uk-icon-link"
                  uk-icon="icon:push; ratio:1"
                ></a> -->
                <a href="{{route('user_edit_property',['property_id'=>$property->id])}}" style="color:blue" uk-tooltip="Edit Property" class="uk-icon-link"
                  uk-icon="icon:file-edit; ratio:1"></a>
                <a href="#" style="color:red" uk-tooltip="Delete Property" class="uk-icon-link"
                  uk-icon="icon:trash; ratio:1"></a>
              </td>
            </tr>
            @endforeach
            @else
            <tr>
              <td colspan="6" class="uk-text-center">No Data Yet</td>
            </tr>
            @endif
          </tbody>
        </table>
        <hr />
        <div class="uk-flex-center" uk-margin>
          {{$properties->appends(request()->query())->links()}}
        </div>
        <!----table end here----------->
      </div>
    </div>
  </div>
</div>

<!-----userdashboard end here----->
@endsection
