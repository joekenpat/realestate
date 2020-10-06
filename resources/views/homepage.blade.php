@extends('layouts.app')
@section('title', " Lands, Homes and Apartments")
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

  .my-line {
    margin-top: -75px;
  }

  .home_ad_list_thumb {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 20px;
    padding: 5px
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

  .rem_pl:first-of-type {
    padding-left: 0;
  }

  .rem_pl {
    padding-left: 15px;
  }

  @media (max-width: 740px) {
    .rem_pl {
      padding-left: 0;
      margin-bottom: 15px;
    }

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

  .agent_logo {
    height: 40px;
    width: 40px;
    object-fit: cover;
  }
</style>
@endpush
@push('scripts_bottom')
<script>
  function load_subcat() {
  var sub_cat = document.getElementById('subscription_category')
  var sub_scat = document.getElementById('subscription_subcategory')
  var cat_data ={!!$sub_cat!!};
  var sel_cat = sub_cat.options[sub_cat.selectedIndex].value
  if (sub_cat !== '') {
    sub_scat.length = 1
    cat_data.forEach(cat_data => {
        if (cat_data.id == sel_cat) {
          cat_data.subcategories.forEach(scat_data => {
            var option = document.createElement("option");
                  option.text = scat_data.name;
                  option.value= scat_data.id;
                  sub_scat.add(option);
          });
        }
      });
  }
}
</script>
@endpush
@section('content')
<!-----slider start here---->
<div class="uk-position-relative uk-visible-toggle" tabindex="-1"
  uk-slideshow="autoplay: true; animation: push; min-height: 10000; max-height: 600">

  <ul class="uk-slideshow-items">
    @foreach ($slider_images as $image)
    <li>
      <img src="{{asset('images/misc/'.$image)}}" alt="" uk-cover>
      <div class="uk-overlay-primary uk-position-cover"></div>
      <div class="uk-overlay uk-container  uk-light landing-text">
        <div class=" uk-position-relative uk-position-small uk-text-center uk-light my-slide">
          <h1 class="uk-margin-remove" style="padding-top: 100px"><b>Lands, Homes & Apartments
            </b></h1>
          <h5 class="uk-margin-remove uk-margin-small-top"><b>We make it easy for you to buy or sell your properties for
              big turnover.
              stress-free</b></h5>
          <div class="uk-width-1-1 uk-margin-large-top" style="">
            <form action="{{route('property_listing')}}" class="uk-width-1-1" method="GET">
              <div class="uk-grid-collapse uk-padding-small uk-border-rounded uk-flex uk-flex-center"
                style="background-color:rgba(255, 255, 255, 0.3)" uk-grid>
                <div class="uk-width-1-3@m uk-width-1-1 rem_pl">
                  <div class="uk-margin">
                    <input class="uk-input" type="text" id="findable" name="findable" placeholder="Enter Search term">
                  </div>
                </div>
                <div class="uk-width-1-3@m uk-width-1-1 rem_pl">
                  <div class="uk-margin">
                    <div class="uk-form-controls">
                      <select class="uk-select" id="state" name="state">
                        <option value="all">Select State</option>
                        @foreach ($states as $state)
                        <option value="{{$state->id}}">{{ucwords($state->name)}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="uk-width-1-3@m uk-width-1-1 rem_pl">
                  <div class="uk-margin">
                    <div class="uk-form-controls">
                      <select class="uk-select" id="category" name="category">
                        <option value="all">Select Category</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{ucwords($category->name)}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <button type="submit"
                class="uk-margin-small-top uk-button-large uk-text-bold uk-button uk-width-1-1 uk-width-1-2@m"
                style=" background: #87ceeb; border-radius:5px ; color: white">Search</button>
            </form>
          </div>
        </div>
      </div>
    </li>
    @endforeach
  </ul>

  <div class="uk-light">
    <a class="uk-position-center-left uk-position-small " href="#" uk-slidenav-previous
      uk-slideshow-item="previous"></a>
    <a class="uk-position-center-right uk-position-small " href="#" uk-slidenav-next uk-slideshow-item="next"></a>
  </div>

</div>
<!-----slider end here------>

<!---top properties start here---->
@if(count($featured_properties))
<div class="top-post uk-text-center uk-margin">
  <h3> <i class="mdi  mdi-minus" style="color: #87ceeb; font-size: 40px;"></i><b>Featured Properties
    </b><i class="mdi  mdi-minus" style="color: #87ceeb; font-size: 40px;"></i></h3>
</div>
<div class="uk-container">
  <div class="uk-position-relative uk-visible-toggle">
    <div class="uk-grid uk-child-width-1-4@m uk-child-width-1-3@s uk-child-width-1-1 uk-grid-small">
      @foreach ($featured_properties as $property)
      <div class="ads-listing my-margin uk-margin-small-bottom">
        <div class="uk-container uk-padding-remove uk-margin ">
          <div class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-small my-card uk-link-text">
            <div class="uk-card-media-top ">
              <a href="{{route('view_property',['property_slug'=>$property->slug])}}" class="uk-link-reset">
                @if(count($property->images))
                <img class="home_ad_list_thumb"
                  src="{{asset(sprintf('images/properties/%s/%s',$property->id,$property->images[0]))}}" alt="" />
                @else
                <img class="home_ad_list_thumb" src="{{asset(sprintf('images/misc/no-image.jpg'))}}" alt="" />
                @endif
              </a>
              @if($property->plan == 'featured')
              <!--featured start here-->
              <div class="uk-overlay uk-card-default  uk-position-top-left uk-position-small uk-padding-left-remove"
                style="border-radius:50px; height: 25px; padding:5px;  margin: 20px; background-color: #FFD700; color: white ">
                <p class="uk-text-small" style="padding:0px 6px">
                  <i uk-icon="icon:star; ratio:1" style="color:white;"></i>
                  For {{ $property->list_as }}
                </p>
              </div>
              <!--featured end here-->
              @elseif($property->plan == 'vip')
              <!--distress start here-->
              <div class="uk-overlay uk-card-default  uk-position-top-left uk-position-small uk-padding-left-remove"
                style="border-radius:50px; height: 25px; padding:5px;  margin: 20px; background-color: red; color: white ">
                <p class="uk-text-small" style="padding:0px 6px">
                  <i uk-icon="icon:rss; ratio:1" style="color:white;"></i>
                  For {{ $property->list_as }}
                </p>
              </div>
              <!--distress end here-->
              @elseif($property->plan == 'premium')
              <!--premium start here-->
              <div class="uk-overlay uk-card-default  uk-position-top-left uk-position-small uk-padding-left-remove"
                style="border-radius:50px; height: 25px; padding:5px;  margin: 20px; background-color: purple; color: white ">
                <p class="uk-text-small" style="padding:0px 6px">
                  <i uk-icon="icon:rss; ratio:1" style="color:white;"></i>
                  For {{ $property->list_as }}
                </p>
              </div>
              <!--premium end here-->
              @else
              <!--free start here-->
              <div class="uk-overlay uk-card-default  uk-position-top-left uk-position-small uk-padding-left-remove"
                style="border-radius:50px; height: 25px; padding:5px;  margin: 20px; background-color:black; color: white ">
                <P class="uk-text-small" style="padding:0px 6px">
                  <i uk-icon="icon:bell; ratio:1" style="color:white;"></i>For {{ $property->list_as }}</P>
              </div>
              <!--free end here-->
              @endif
              <!--like ad start here-->
              <button class="uk-position-top-right uk-button uk-position-small uk-border-pill"
                style="color: #FFD700; background:#fff; padding:0px 6px">
                <i uk-icon="icon:heart;ratio:1"></i> {{$property->favourites_count}}
              </button>
              <!--like ad end here-->
            </div>
            <div class="uk-card-body uk-text-center uk-padding-small">
              <a href="{{route('view_property',['property_slug'=>$property->slug])}}" class="uk-link-reset">
                <h5 class="red-text uk-text-small uk-display-block uk-text-truncate">{{$property->title}}</h5>
                <h4 class="my-card-title red-text">
                  &#8358;{{ number_format($property->price) }}
                </h4>
              </a>

              <p class="uk-text-small">
                <i style="color: #87ceeb;" uk-icon="icon:location; ratio:.8"></i>
                {{ $property->city->name }}, {{ $property->state->name }}
              </p>
              <div class="uk-text-small" uk-grid>
                <div class="uk-width-1-2">
                  <p class=" uk-text-capitalize">
                    <a class="uk-button uk-button-small"> {{ $property->category->name }}</a>
                  </p>
                </div>
                <div class="uk-width-1-2">
                  <img
                    src="{{$property->user->avatar != null?URL::to(sprintf("images/users/profile/%s/%s",$property->user->id,$property->user->avatar)):asset("images/misc/default_avatar.png") }}"
                    class="uk-border-circle agent_logo" alt="property agent image">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
<!---top properties view all button-->
<div class="uk-text-center uk-margin-large-top uk-margin-large-bottom">
  <a href="{{route('property_listing',['sort_by'=>'price','plan'=>'featured'])}}"
    class="uk-button blue darken-1 white-text uk-border-rounded">View All</a>
</div>
<!---top properties end here---->
@endisset

@if(count($recent_properties))
<!---latest properties start here---->
<div class="top-post uk-text-center uk-margin">
  <h3> <i class="mdi  mdi-minus" style="color: #87ceeb; font-size: 40px;"></i><b>Recent Properties</b><i
      class="mdi  mdi-minus" style="color: #87ceeb; font-size: 40px;"></i></h3>
</div>
<div class="uk-container">
  <div class="uk-position-relative uk-visible-toggle">
    <div class="uk-grid uk-child-width-1-4@m uk-child-width-1-3@s uk-child-width-1-1 uk-grid-small">
      @foreach ($recent_properties as $property)
      <div class="ads-listing my-margin uk-margin-small-bottom">
        <div class="uk-container uk-padding-remove uk-margin ">
          <div class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-small my-card uk-link-text">
            <div class="uk-card-media-top ">
              <a href="{{route('view_property',['property_slug'=>$property->slug])}}" class="uk-link-reset">
                @if(count($property->images))
                <img class="home_ad_list_thumb"
                  src="{{asset(sprintf('images/properties/%s/%s',$property->id,$property->images[0]))}}" alt="" />
                @else
                <img class="home_ad_list_thumb" src="{{asset(sprintf('images/misc/no-image.jpg'))}}" alt="" />
                @endif
              </a>

              @if($property->plan == 'featured')
              <!--featured start here-->
              <div class="uk-overlay uk-card-default  uk-position-top-left uk-position-small uk-padding-left-remove"
                style="border-radius:50px; height: 25px; padding:5px;  margin: 20px; background-color: #FFD700; color: white ">
                <p class="uk-text-small" style="padding:0px 6px">
                  <i uk-icon="icon:star; ratio:1" style="color:white;"></i>
                  For {{ $property->list_as }}
                </p>
              </div>
              <!--featured end here-->
              @elseif($property->plan == 'vip')
              <!--distress start here-->
              <div class="uk-overlay uk-card-default  uk-position-top-left uk-position-small uk-padding-left-remove"
                style="border-radius:50px; height: 25px; padding:5px;  margin: 20px; background-color: red; color: white ">
                <p class="uk-text-small" style="padding:0px 6px">
                  <i uk-icon="icon:rss; ratio:1" style="color:white;"></i>
                  For {{ $property->list_as }}
                </p>
              </div>
              <!--distress end here-->
              @elseif($property->plan == 'premium')
              <!--premium start here-->
              <div class="uk-overlay uk-card-default  uk-position-top-left uk-position-small uk-padding-left-remove"
                style="border-radius:50px; height: 25px; padding:5px;  margin: 20px; background-color: purple; color: white ">
                <p class="uk-text-small" style="padding:0px 6px">
                  <i uk-icon="icon:rss; ratio:1" style="color:white;"></i>
                  For {{ $property->list_as }}
                </p>
              </div>
              <!--premium end here-->
              @else
              <!--free start here-->
              <div class="uk-overlay uk-card-default  uk-position-top-left uk-position-small uk-padding-left-remove"
                style="border-radius:50px; height: 25px; padding:5px;  margin: 20px; background-color:black; color: white ">
                <P class="uk-text-small" style="padding:0px 6px">
                  <i uk-icon="icon:bell; ratio:1" style="color:white;"></i>For {{ $property->list_as }}</P>
              </div>
              <!--free end here-->
              @endif
              <!--like ad start here-->
              <button class="uk-position-top-right uk-button uk-position-small uk-border-pill"
                style="color: #FFD700; background:#fff; padding:0px 6px">
                <i uk-icon="icon:heart;ratio:1"></i> {{$property->favourites_count}}
              </button>
              <!--like ad end here-->
            </div>
            <div class="uk-card-body uk-text-center uk-padding-small">
              <a href="{{route('view_property',['property_slug'=>$property->slug])}}" class="uk-link-reset">
                <h5 class="red-text uk-text-small uk-display-block uk-text-truncate">{{$property->title}}</h5>
                <h4 class="my-card-title red-text">
                  &#8358;{{ number_format($property->price) }}
                </h4>
              </a>

              <p class="uk-text-small">
                <i style="color: #87ceeb;" uk-icon="icon:location; ratio:.8"></i>
                {{ $property->city->name }}, {{ $property->state->name }}
              </p>
              <div class="uk-text-small uk-grid-collapse" uk-grid>
                <div class="uk-width-2-3">
                  <a href="{{route('property_listing',['category'=>$property->category->id])}}"
                    class="uk-button uk-button-default uk-padding-remove-horizontal uk-border-pill grey darken-3 uk-text-bold white-text uk-text-truncate uk-margin-remove uk-width-1-1 uk-align-center">
                    {{ $property->category->name }}</a>
                </div>
                <div class="uk-width-1-3">
                  <img
                    src="{{$property->user->avatar != null?URL::to(sprintf("images/users/profile/%s/%s",$property->user->id,$property->user->avatar)):asset("images/misc/default_avatar.png") }}"
                    class="uk-border-circle agent_logo uk-align-right" alt="ad agent image">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
<!---latest properties view all button-->
<div class="uk-text-center uk-margin-large-top uk-margin-large-bottom">
  <a href="{{route('property_listing',['sort_by'=>'created_at','plan'=>'all'])}}"
    class="uk-button blue darken-1 white-text uk-border-rounded">View All</a>
</div>
<!---top properties start here---->
@endisset
<!----properties by city start here-->
<div class="city">
  <div class="uk-container">
    <div class="top-post uk-text-center uk-margin">
      <h3> <i class="mdi  mdi-minus" style="color: #87ceeb; font-size: 40px;"></i><b> Popular
          Cities</b><i class="mdi  mdi-minus" style="color: #87ceeb; font-size: 40px;"></i></h3>
    </div>

    <div uk-grid>
      <div class="uk-width-1-4@m uk-width-1-2">
        <div class="uk-card uk-card-default my-card">
          <a href="{{route('property_listing',['state'=>25])}}">
            <div class="uk-card-media-top">
              <img class="top-p-image uk-width-1-1" src="images/misc/lagos.jpg" alt="">
              <div class="uk-overlay uk-overlay-primary uk-position-cover"
                style="color: white; opacity:0.2; border-radius:20px ">
              </div>
              <div class="uk-overlay uk-position-center uk-light">
                <p class="uk-text-large uk-text-bold">Lagos</p>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="uk-width-1-4@m uk-width-1-2">
        <div class="uk-card uk-card-default my-card">
          <a href="{{route('property_listing',['state'=>1])}}">
            <div class="uk-card-media-top">
              <img class="top-p-image uk-width-1-1" src="images/misc/abj.jpg" alt="">
              <div class="uk-overlay uk-overlay-primary uk-position-cover"
                style="color: white; opacity:0.2; border-radius:20px ">
              </div>
              <div class="uk-overlay uk-position-center uk-light">
                <p class="uk-text-large uk-text-bold">Abuja</p>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="uk-width-1-4@m uk-width-1-2">
        <div class="uk-card uk-card-default my-card">
          <a href="{{route('property_listing',['state'=>33])}}">
            <div class="uk-card-media-top">
              <img class="top-p-image uk-width-1-1" src="images/misc/ph2.jpg" alt="">
              <div class="uk-overlay uk-overlay-primary uk-position-cover"
                style="color: white; opacity:0.2; border-radius:20px ">
              </div>
              <div class="uk-overlay uk-position-center uk-light">
                <p class="uk-text-large uk-text-bold uk-text-center">Port<br>Harcourt</p>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="uk-width-1-4@m uk-width-1-2">
        <div class="uk-card uk-card-default my-card">
          <a href="{{route('property_listing',['state'=>17])}}">
            <div class="uk-card-media-top">
              <img class="top-p-image uk-width-1-1" src="images/misc/ot1.jpg" alt="">
              <div class="uk-overlay uk-overlay-primary uk-position-cover"
                style="color: white; opacity:0.2; border-radius:20px ">
              </div>
              <div class="uk-overlay uk-position-center uk-light">
                <p class="uk-text-large uk-text-bold">Owerri</p>
              </div>
            </div>
          </a>
        </div>
      </div>

    </div>
  </div>
</div>
<!----properties by city end  here-->

<div class="uk-container uk-margin-top uk-margin-bottom content-property-alert">
  <div uk-grid>
    <div class="uk-width-1-2@m uk-width-1-1@s" style="margin-top: 12% ">
      <h1><b>Did You Know?</b></h1>
      <p>You can create a property alert of a particular property, which you couldn't see here at the moment. Once such
        property is avilable you will get notified </p>
    </div>
    <div class="uk-width-1-2@m uk-width-1-1@s uk-margin">
      <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-width-1-1" style="border-radius: 20px">
        <h4 class="uk-card-title uk-text-bold">Subscribe Now</h4>
        <form method="POST" action="{{route('property_subscribe')}}" class="uk-grid-small uk-margin" uk-grid>
          @csrf
          <div class="uk-width-1-1">
            <label class="uk-form-label" for="subscription_name">Name <span
                class="red-text uk-text-bold">*</span></label>
            <input class="uk-input @error('subscription_email') uk-form-danger @enderror" type="text"
              name="subscription_name" value="{{old('subscription_name')}}" id="subscription_name" placeholder="name">
            @error('subscription_name')
            <span class="uk-text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="uk-width-1-1">
            <label class="uk-form-label" for="subscription_email">Email <span
                class="red-text uk-text-bold">*</span></label>
            <input class="uk-input @error('subscription_email') uk-form-danger @enderror" type="email"
              name="subscription_email" value="{{old('subscription_email')}}" id="subscription_email"
              placeholder="email">
            @error('subscription_email')
            <span class="uk-text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="uk-width-1-2">
            <label class="uk-form-label" for="subscription_phone">Phone No <span
                class="red-text uk-text-bold">*</span></label>
            <input name="subscription_phone" value="{{old('subscription_phone')}}" id="subscription_phone"
              class="uk-input @error('subscription_phone') uk-form-danger @enderror" type="text" placeholder="phone">
            @error('subscription_phone')
            <span class="uk-text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="uk-width-1-2">
            <label class="uk-form-label" for="subscription_state">State <span
                class="red-text uk-text-bold">*</span></label>
            <select class="uk-select @error('subscription_state') uk-form-danger @enderror" id="subscription_state"
              name="subscription_state">
              <option value="all">Select State</option>
              @foreach ($states as $state)
              <option value="{{$state->id}}">{{ucwords($state->name)}}</option>
              @endforeach
            </select>
            @error('subscription_state')
            <span class="uk-text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="uk-width-1-2">
            <label class="uk-form-label" for="subscription_category">Category <span
                class="red-text uk-text-bold">*</span></label>
            <select onchange="load_subcat()" class="uk-select @error('subscription_category') uk-form-danger @enderror"
              id="subscription_category" name="subscription_category">
              <option value="all">Select Category</option>
              @foreach ($categories as $category)
              <option value="{{$category->id}}">{{ucwords($category->name)}}</option>
              @endforeach
            </select>
            @error('subscription_category')
            <span class="uk-text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="uk-width-1-2">
            <label class="uk-form-label" for="subscription_subcategory">SubCategory</label>
            <select class="uk-select @error('subscription_subcategory') uk-form-danger @enderror"
              id="subscription_subcategory" name="subscription_subcategory">
              <option value="all">Select SubCategory</option>
            </select>
            @error('subscription_subcategory')
            <span class="uk-text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="uk-width-1-1">
            <button type="submit" class="uk-margin-small-top  uk-text-bold uk-button uk-width-1-1"
              style=" background: #87ceeb; border-radius:5px ; color: white">Subscribe</button>
          </div>
      </div>
      </form>

    </div>
  </div>
</div>
</div>
@endsection
