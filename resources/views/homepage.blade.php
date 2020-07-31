@extends('layouts.app')
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

  /* .dashboard-main {
    margin-top: 8%;
  }

  .dashboard-main2 {
    width: 50%;
  } */

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

  /* .dashboard-main {
    width: 70%;
    margin-top: 8%;
  }

  .dashboard-main2 {
    width: 50%;
  } */

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
</style>
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
          <h1 class="uk-margin-remove" style="padding-top: 100px"><b>Find Your Next Land</b></h1>
          <h5 class="uk-margin-remove" style="padding-top: 10px"><b>We Make It Easy To Get A Land Property</b></h5>
          <div class="uk-margin-remove" style="padding-top: 50px">
            <form>
              <div class="uk-grid-small" uk-grid>
                <div class="uk-width-1-3@m uk-width-1-1@s">
                  <div class="uk-margin">
                    <input class="uk-input" type="text" id="location" placeholder="Enter Location, Landmark">
                  </div>
                </div>
                <div class="uk-width-1-3@m uk-width-1-1@s">
                  <div class="uk-margin">
                    <div class="uk-form-controls">
                      <select class="uk-select" id="form-stacked-select">
                        <option>Option 01</option>
                        <option>Option 02</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="uk-width-1-3@m uk-width-1-1@s">
                  <div class="uk-margin">
                    <div class="uk-form-controls">
                      <select class="uk-select" id="form-stacked-select">
                        <option>Option 01</option>
                        <option>Option 02</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div style="padding-top: 30px">
                <button class="uk-button uk-button-large"
                  style=" background: #87ceeb; border-radius:10px ; color: white">search</button>
              </div>
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
<div class="top-post uk-text-center uk-margin">
  <h3> <i class="mdi  mdi-minus" style="color: #87ceeb; font-size: 40px;"></i><b>Top Properties
    </b><i class="mdi  mdi-minus" style="color: #87ceeb; font-size: 40px;"></i></h3>
</div>
<div class="uk-container">
  <div uk-slider="center: true">

    <div class="uk-position-relative uk-visible-toggle" tabindex="-1">

      <ul class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-2@s uk-child-width-1-1 uk-grid-small">
        @foreach ($properties as $property)
        <li class="ads-listing my-margin">
          <div class="uk-container uk-padding-remove uk-margin ">
            <div class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-small my-card uk-link-text">
              <a href="{{route('view_property',['property_id'=>$property->id])}}" class="uk-link-reset">
                <div class="uk-card-media-top ">
                  <img class="home_ad_list_thumb"
                    src="{{asset(sprintf('images/properties/%s/%s',$property->id,$property->images[0]))}}" alt="" />

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
                  @elseif($property->plan == 'distress')
                  <!--distress start here-->
                  <div class="uk-overlay uk-card-default  uk-position-top-left uk-position-small uk-padding-left-remove"
                    style="border-radius:50px; height: 25px; padding:5px;  margin: 20px; background-color: red; color: white ">
                    <p class="uk-text-small" style="padding:0px 6px">
                      <i uk-icon="icon:rss; ratio:1" style="color:white;"></i>
                      For {{ $property->list_as }}
                    </p>
                  </div>
                  <!--distress end here-->
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
                    <i uk-icon="icon:heart;ratio:1"></i> {{$property->favourite_count()}}
                  </button>
                  <!--like ad end here-->
                </div>
                <div class="uk-card-body uk-text-center uk-padding-small">
                  <h4 class="my-card-title">
                    <i style="color:#adf802;" uk-icon="icon:hashtag"></i>{{ number_format($property->price) }}
                  </h4>

                  <p class="uk-text-small">
                    <i style="color: #87ceeb;" uk-icon="icon:location; ratio:.8"></i>
                    {{ $property->city->name }}, {{ $property->state->name }}
                  </p>
                  <div class="uk-text-small" uk-grid>
                    <div class="uk-width-1-2">
                      <p>
                        {{ $property->specifications[0]->name }}
                        {{ $property->specifications[0]->value }}
                      </p>
                    </div>
                    <div class="uk-width-1-2">
                      <p>{{ $property->created_at->diffForHumans() }}</p>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </li>
        @endforeach
      </ul>

      <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
        uk-slider-item="previous"></a>
      <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
        uk-slider-item="next"></a>

    </div>

    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

  </div>
</div>
<!---top properties view all button-->
<div class="uk-text-center">
  <a href="{{route('property_listing',['sort_by'=>'price','plan'=>'featured'])}}" class="uk-button " style="background-color:#87ceeb;color:white; border-radius: 10px ">View All</a>
</div>
<!---top properties end here---->

<!---latest properties start here---->
<div class="top-post uk-text-center uk-margin">
  <h3> <i class="mdi  mdi-minus" style="color: #87ceeb; font-size: 40px;"></i><b>Latest Properties</b><i
      class="mdi  mdi-minus" style="color: #87ceeb; font-size: 40px;"></i></h3>
</div>
<div class="uk-container">
  <div uk-slider="center: true">

    <div class="uk-position-relative uk-visible-toggle" tabindex="-1">

      <ul class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-2@s uk-child-width-1-1 uk-grid-small">
        @foreach ($properties as $property)
        <li class="ads-listing my-margin">
          <div class="uk-container uk-padding-remove uk-margin ">
            <div class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-small my-card uk-link-text">
              <a href="{{route('view_property',['property_id'=>$property->id])}}" class="uk-link-reset">
                <div class="uk-card-media-top ">
                  <img class="home_ad_list_thumb"
                    src="{{asset(sprintf('images/properties/%s/%s',$property->id,$property->images[0]))}}" alt="" />

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
                  @elseif($property->plan == 'distress')
                  <!--distress start here-->
                  <div class="uk-overlay uk-card-default  uk-position-top-left uk-position-small uk-padding-left-remove"
                    style="border-radius:50px; height: 25px; padding:5px;  margin: 20px; background-color: red; color: white ">
                    <p class="uk-text-small" style="padding:0px 6px">
                      <i uk-icon="icon:rss; ratio:1" style="color:white;"></i>
                      For {{ $property->list_as }}
                    </p>
                  </div>
                  <!--distress end here-->
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
                    <i uk-icon="icon:heart;ratio:1"></i> {{$property->favourite_count()}}
                  </button>
                  <!--like ad end here-->
                </div>
                <div class="uk-card-body uk-text-center uk-padding-small">
                  <h4 class="my-card-title">
                    <i style="color:#adf802;" uk-icon="icon:hashtag"></i>{{ number_format($property->price) }}
                  </h4>

                  <p class="uk-text-small">
                    <i style="color: #87ceeb;" uk-icon="icon:location; ratio:.8"></i>
                    {{ $property->city->name }}, {{ $property->state->name }}
                  </p>
                  <div class="uk-text-small" uk-grid>
                    <div class="uk-width-1-2">
                      <p>
                        {{ $property->specifications[0]->name }}
                        {{ $property->specifications[0]->value }}
                      </p>
                    </div>
                    <div class="uk-width-1-2">
                      <p>{{ $property->created_at->diffForHumans() }}</p>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </li>
        @endforeach
      </ul>

      <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
        uk-slider-item="previous"></a>
      <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
        uk-slider-item="next"></a>

    </div>

    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

  </div>
</div>
<!---latest properties view all button-->
<div class="uk-text-center">
<a href="{{route('property_listing',['sort_by'=>'created_at'])}}" class="uk-button "
    style="background-color:#87ceeb;color:white; border-radius: 10px; margin-bottom: 20px ">View All</a>
</div>
<!---top properties start here---->

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
          <div class="uk-card-media-top">
            <img class="top-p-image " src="images/lagos.jpg" alt="">
            <div class="uk-overlay uk-overlay-primary uk-position-center uk-position-small"
              style=" height: 0px; padding-top:15px;  margin: 20px;  color: white ">
              <p class="city-text-s"><b>Lagos</b></p>
            </div>
          </div>
        </div>
      </div>
      <div class="uk-width-1-4@m uk-width-1-2">
        <div class="uk-card uk-card-default my-card">
          <div class="uk-card-media-top">
            <img class="top-p-image " src="images/abj.jpg" alt="">
            <div class="uk-overlay uk-overlay-primary uk-position-center uk-position-small"
              style=" height: 0px; padding-top:15px;  margin: 20px;  color: white ">
              <p class="city-text-s"><b>Abuja</b></p>
            </div>
          </div>
        </div>
      </div>
      <div class="uk-width-1-4@m uk-width-1-2">
        <div class="uk-card uk-card-default my-card">
          <div class="uk-card-media-top">
            <img class="top-p-image " src="images/ph2.jpg" alt="">
            <div class="uk-overlay uk-overlay-primary uk-position-center uk-position-small"
              style=" height: 0px; padding-top:15px;  margin: 20px;  color: white ">
              <p class="city-text-s"><b>PortHarcourt</b></p>
            </div>
          </div>
        </div>
      </div>
      <div class="uk-width-1-4@m uk-width-1-2">
        <div class="uk-card uk-card-default my-card">
          <div class="uk-card-media-top">
            <img class="top-p-image " src="images/ot1.jpg" alt="">
            <div class="uk-overlay uk-overlay-primary uk-position-center uk-position-small"
              style=" height: 0px; padding-top:15px;  margin: 20px;  color: white ">
              <p class="city-text-s"><b>Owerri</b></p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<!----properties by city end  here-->

<!---blog start here---->
<div class="top-post uk-text-center uk-margin">
  <h3> <i class="mdi  mdi-minus" style="color: #87ceeb; font-size: 40px;"></i><b>Blog</b><i class="mdi  mdi-minus"
      style="color: #87ceeb; font-size: 40px;"></i></h3>
</div>
<div class="uk-container">
  <div uk-slider="center: true">

    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">

      <ul class="uk-slider-items uk-child-width-1-2@s uk-grid ">
        <li>
          <a href="">
            <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin my-card-blog" uk-grid>
              <div class="uk-card-media-left uk-cover-container">
                <img src="images/vincentiu-solomon-7MH4ped6_Mo-unsplash (1).jpg" alt="" uk-cover>
                <canvas width="600" height="400"></canvas>
              </div>
              <div>
                <div class="uk-card-body">
                  <h3 class="uk-card-title">Media Left</h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                    tempor incididunt.</p>
                  <p class="uk-text-meta uk-margin-remove-top"><time datetime="2016-04-01T19:00"
                      style="color: #87ceeb">April 01, 2016</time></p>
                </div>
              </div>
            </div>

          </a>
        </li>
        <li>
          <a href="">
            <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin my-card-blog" uk-grid>
              <div class="uk-card-media-left uk-cover-container">
                <img src="images/christian-wiediger-RYWEyXopmM4-unsplash.jpg" alt="" uk-cover>
                <canvas width="600" height="400"></canvas>
              </div>
              <div>
                <div class="uk-card-body">
                  <h3 class="uk-card-title">Media Left</h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                    tempor incididunt.</p>
                  <p class="uk-text-meta uk-margin-remove-top"><time datetime="2016-04-01T19:00"
                      style="color: #87ceeb">April 01, 2016</time></p>
                </div>
              </div>
            </div>
          </a>
        </li>
        <li>
          <a href="">
            <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin my-card-blog" uk-grid>
              <div class="uk-card-media-left uk-cover-container">
                <img src="images/pp7.jpg" alt="" uk-cover>
                <canvas width="600" height="400"></canvas>
              </div>
              <div>
                <div class="uk-card-body">
                  <h3 class="uk-card-title">Media Left</h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                    tempor incididunt.</p>
                  <p class="uk-text-meta uk-margin-remove-top"><time datetime="2016-04-01T19:00"
                      style="color: #87ceeb">April 01, 2016</time></p>
                </div>
              </div>
            </div>
          </a>
        </li>
        <li>
          <a href="">
            <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin my-card-blog" uk-grid>
              <div class="uk-card-media-left uk-cover-container">
                <img src="images/florian-schmidinger-b_79nOqf95I-unsplash.jpg" alt="" uk-cover>
                <canvas width="600" height="400"></canvas>
              </div>
              <div>
                <div class="uk-card-body">
                  <h3 class="uk-card-title">Media Left</h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                    tempor incididunt.</p>
                  <p class="uk-text-meta uk-margin-remove-top"><time datetime="2016-04-01T19:00"
                      style="color: #87ceeb">April 01, 2016</time></p>
                </div>
              </div>
            </div>

          </a>
        </li>
      </ul>

      <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
        uk-slider-item="previous"></a>
      <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
        uk-slider-item="next"></a>

    </div>

    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

  </div>
</div>
<!---latest properties view all button-->
<div class="uk-text-center">
  <a href="" class="uk-button "
    style="background-color:#87ceeb;color:white; border-radius: 10px; margin-bottom: 20px ">View All</a>
</div>
<!---blog end here---->
@endsection
