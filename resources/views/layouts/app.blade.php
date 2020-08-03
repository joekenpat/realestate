<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'MyNextLand') }} @yield('title')</title>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>
    .my-footer {
      background-color: rgb(31, 29, 29);

    }

    .my-footer-text {
      color: white;
      font-size: 0.9em;
    }

    .my-footer-content {
      color: #87ceeb;
      padding-top: 70px;
    }

    @media (max-width: 740px) {
      .my-slide {
        padding-top: none
      }

      .my-footer-content {
        color: #87ceeb;
        padding-top: 1px;
      }

    }



    html {
      background-color: white;
    }

    .navigation {
      background-color: black !important;
      width: 100%;
      margin: 0px;
      margin-top: 0px;
      padding-top: 0px;
    }

    .navigation-small {
      background-color: black !important;
      width: 100%;
      margin: 0px;
      margin-top: 0px;
      padding-top: 0px;
    }

    .btn-nav-login {
      background: white !important;
      color: black;
      text-decoration-style: solid;
      border-radius: 50px;
      margin-right: 10px;
    }

    .btn-nav-login:hover {
      background-color: yellow;
    }

    .btn-nav-register {
      background: red !important;
      color: white;
      text-decoration-style: solid;
      border-radius: 50px;
    }

    .btn-bg-none {
      background: none !important;
      color: white;
    }

    .content {
      max-width: 1100px;
      margin: auto;
    }

    .top-p-image {
      border-radius: 20px;
      padding: 5px
    }


    .uk-fixed-navigation {
      position: fixed;
      right: 0;
      left: 0;
      top: 0;
      z-index: 1030;
    }

    .my-card-title {
      margin: -20px
    }

    .my-card-text {
      margin-bottom: -20px
    }

    .my-card-text-blog {
      font-size: 0.8em
    }

    .my-card {
      border-radius: 20px;
    }

    .my-card-blog {
      border-radius: 0px 20px 20px 0px;
    }

    .city {
      background: whitesmoke;
      padding-bottom: 50px;
    }

    .city-text-s {
      font-size: 0.7em
    }
  </style>
  <script>
    window.Laravel = @php echo json_encode([
      'csrfToken'=> csrf_token(),
    ]) @endphp;
    @if(!auth()->guest())
      window.Laravel.userId = "{{auth()->user()->id}}";
    @endif
  </script>
  @stack('style_top')
  @stack('scripts_top')
</head>

<body>
  <div id="app">
    <!----offcanvas start here---->
    <div id="side_menu" uk-offcanvas="mode: push; overlay: true">
      <div class="uk-offcanvas-bar sidenav ">

        <!-----usefull links ends here---->
        <ul class="uk-nav uk-nav-default " uk-nav>
          <li>
            <div class="uk-padding-remove uk-margin-small">
              <a href="{{route('user_create_property')}}"
                class="uk-button green accent-4 white-text uk-width-1-1 uk-border-rounded">POST
                ADS</a>
            </div>
          </li>
          @if(Route::currentRouteName() == 'property_listing')
          <li class="uk-parent uk-padding-remove uk-margin-small">
            <a class="uk-button blue accent-2 white-text uk-width-1-1 uk-border-rounded" href="#">Filter Property</a>
            <ul>
              <li>
                <form id="filter_form" action="{{route('property_listing')}}" method="get">
                  <div class="uk-padding-small">
                    <h5 class="uk-margin-remove uk-text-bold" style="color: #87ceeb;">
                      Plan
                    </h5>
                  </div>
                  <div class="uk-grid-small uk-child-width-1-1 uk-padding-small uk-padding-remove-top" uk-grid>
                    <div>
                      <select name="plan" id="plan" class="uk-select uk-border-rounded">
                        <option selected value="all">All</option>
                        <option value="free">Free</option>
                        <option value="distress">Distress</option>
                        <option value="featured">Featured</option>
                      </select>
                    </div>
                  </div>
                  <hr class="uk-margin-remove" />
                  <div class="uk-padding-small">
                    <h5 class="uk-margin-remove uk-text-bold" style="color: #87ceeb;">
                      Category
                    </h5>
                  </div>

                  <div class="uk-grid-small uk-child-width-1-1 uk-padding-small uk-padding-remove-top" uk-grid>
                    <div class="">
                      <select class="uk-select uk-border-rounded" id="category" name="category">
                        <option selected value="all">All</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{ucwords($category->name)}}</option>
                        @endforeach
                        </option>
                      </select>
                    </div>
                  </div>
                  <hr class="uk-margin-remove" />
                  <div class="uk-padding-small">
                    <h5 class="uk-margin-remove uk-text-bold" style="color: #87ceeb;">
                      Price Range
                    </h5>
                  </div>
                  <div class="uk-grid-small uk-padding-small uk-padding-remove-top" uk-grid>
                    <div class="uk-width-1-2">
                      <label class="uk-form-label" for="form-stacked-text"><b>min</b></label>
                      <input class="uk-input uk-border-rounded" value="{{$min_val}}" min="{{$min_val}}"
                        :max="{{$max_val}}" id="min_price" name="min_price" type="number" placeholder="100" />
                    </div>
                    <div class="uk-width-1-2">
                      <label class="uk-form-label" for="form-stacked-text"><b>max</b></label>
                      <input class="uk-input uk-border-rounded" value="{{$max_val}}" min="{{$min_val}}"
                        :max="{{$max_val}}" id="max_price" name="max_price" type="number" placeholder="100" />
                    </div>
                  </div>
                  <hr class="uk-margin-remove" />
                  <div class="uk-padding-small">
                    <h5 class="uk-margin-remove uk-text-bold" style="color: #87ceeb;">
                      Ad type
                    </h5>
                  </div>
                  <div class="uk-grid-small uk-child-width-1-1 uk-padding-small uk-padding-remove-top" uk-grid>
                    <div>
                      <select class="uk-select uk-border-rounded">
                        <option selected value="all">All</option>
                        <option value="rent">For Rent</option>
                        <option value="sale">For Sale</option>
                      </select>
                    </div>
                    <div>
                      <button class="uk-button uk-width-1-1 uk-border-rounded"
                        style="color:white; background-color: #87ceeb;" type="submit">
                        Apply Filter
                      </button>
                    </div>
                  </div>
                </form>
              </li>
            </ul>
          </li>
          @endif
          <li>
            <div class="uk-padding-remove uk-margin-small">
              <a href="{{route('home')}}" class="uk-button black white-text uk-width-1-1 uk-border-rounded">HOME</a>
            </div>
          </li>
          <li>
            <div class="uk-padding-remove uk-margin-small">
              <a href="{{route('property_listing')}}"
                class="uk-button black white-text uk-width-1-1 uk-border-rounded">ALL PROPERTY</a>
            </div>
          </li>
          <li>
            <div class="uk-padding-remove uk-margin-small">
              <a href="#" class="uk-button black white-text uk-width-1-1 uk-border-rounded">PRICING</a>
            </div>
          </li>
          <li>
            <div class="uk-padding-remove uk-margin-small">
              <a href="#" class="uk-button black white-text uk-width-1-1 uk-border-rounded">ABOUT
                US
              </a>
            </div>
          </li>
          <li>
            <div class="uk-padding-remove uk-margin-small">
              <a href="#" class="uk-button black white-text uk-width-1-1 uk-border-rounded">CONTACT
                US
              </a>
            </div>
          </li>
          <li>
            <div class="uk-padding-remove uk-margin-small">
              <a href="#" class="uk-button black white-text uk-width-1-1 uk-border-rounded">Blog
              </a>
            </div>
          </li>
          @auth
          <li>
            <div class="uk-padding-remove uk-margin-small">
              <a href="{{route('edit_profile')}}" class="uk-button black white-text uk-width-1-1 uk-border-rounded">EDIT
                PROFILE</a>
            </div>
          </li>
          <li>
            <div class="uk-padding-remove uk-margin-small">
              <a href="{{route('user_list_property')}}"
                class="uk-button black white-text uk-width-1-1 uk-border-rounded">MY
                ADS
              </a>
            </div>
          </li>
          <li>
            <div class="uk-padding-remove uk-margin-small">
              <a href="{{route('user_favourite_property')}}"
                class="uk-button black white-text uk-width-1-1 uk-border-rounded">MY
                FAVOURITE
              </a>
            </div>
          </li>
          @if(Auth::user()->is_agent())
          <li>
            <div class="uk-padding-remove uk-margin-small">
              <a href="{{route('user_property_view')}}"
                class="uk-button black white-text uk-width-1-1 uk-border-rounded">PROPERTY VIEWS
              </a>
            </div>
          </li>
          @endif
          <li>
            <div class="uk-padding-remove uk-margin-small">
              <a href="{{route('user_list_transaction')}}"
                class="uk-button black white-text uk-width-1-1 uk-border-rounded">PAYMENT
              </a>
            </div>
          </li>
          <li>
            <div class="uk-padding-remove uk-margin-small">
              <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();"
                class="uk-button white-text red uk-width-1-1 uk-border-rounded" style="">LOG
                OUT
              </a>
            </div>
          </li>
          @endauth
        </ul>

      </div>
    </div>
    <!----offcanvas ended here---->

    <!----navbar start here ---->
    <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
      <nav class="uk-navbar-container  navigation" uk-navbar>
        <div class="uk-navbar-let">
          <a class="uk-navbar-item uk-logo" href="{{route('home')}}"><img src="{{asset("/images/misc/logo.png")}}"
              style="height: 100px; "></a>
        </div>


        <div class=" uk-navbar-right uk-margin-small-right uk-visible@m">
          <ul class="uk-navbar-nav uk-flex uk-flex-middle">
            <li>
              <a href="#" class="uk-button uk-width-1-1 btn-bg-none uk-text-bold"
                style="color:white;">Pricing</a>
            </li>
            <li>
              <a href="{{route('property_listing')}}" class="uk-button uk-width-1-1 btn-bg-none uk-text-bold" style="color:white;">All Properties</a>
            </li>
            <li>
              <a href="#" class="uk-button uk-width-1-1 btn-bg-none uk-text-bold" style="color:white;">About US</a>
            </li>
            <li>
              <a href="#" class="uk-button uk-width-1-1 btn-bg-none uk-text-bold" style="color:white;">Contact Us</a>
            </li>
            <li>
              <a href="#" class="uk-button uk-width-1-1 btn-bg-none uk-text-bold" style="color:white;">Blog</a>
            </li>
            @guest
            <li>
              <div class="uk-inline">
                <button class="uk-button btn-nav-login" type="button">Login / Register</button>
                <div uk-drop="pos: bottom-justify;mode: click">
                  <div class="uk-card uk-padding-small uk-card-default drop-nav uk-text-center">
                    <a href="{{route('login')}}"
                      class=" uk-button uk-border-pill red white-text uk-margin-small-bottom">Login </a>
                    <a href="{{route('register')}}"
                      class=" uk-button uk-border-pill green white-text uk-margin-small-bottom">Register</a>
                  </div>
                </div>
              </div>
            </li>
            @endguest
            @auth
            <a title="logout" class="uk-button uk-border-pill white-text" href="{{ route('logout') }}"
              onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();"
              style="background-color:#f44336; color:white">
              Logout <span uk-icon="icon: lock; ratio:1.2;"></span>
            </a>
            <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
            @endauth
            <a href="{{route('user_create_property')}}"
              style="height:35px !important;padding-top:5px; text-decoration:none;"
              class="uk-button-small uk-text-bold uk-border-pill uk-margin-small-left white-text green darken-1"> Post Property</a>

          </ul>
        </div>
        <div class="uk-navbar-right uk-hidden@m">
          <ul class="uk-navbar-nav">
            <li>
              <button class="uk-navbar-toggle uk-button uk-button-text white-text" type="button"
                uk-toggle="target: #side_menu"><i uk-icon="icon: menu; ratio:2;"></i></button>
            </li>
          </ul>
        </div>

      </nav>
    </div>
    <!----navbar ends here ---->
    <!-----dashboard start here----->

    <main>
      @yield('content')
    </main>

    <footer id="footer" class="my-footer">
      <div class="uk-container">
        <div class=" uk-margin-top" uk-grid>
          <div class="uk-width-1-4@m uk-width-1-2@s width-1-1">
            <a class="uk-logo" href="{{route('home')}}"><img src="{{asset("/images/misc/logo.png")}}"
                style="height: 100px; "></a>
            <p class="my-footer-text">
              <b>
                86 Petersham town, New South wales
                Waedll Steet, Australia PA 6550
              </b>
            </p>
            <li class="my-footer-text" style="color: #adf802"><span uk-icon="receiver"></span> +234 9037 031000
            </li>
            <li class="my-footer-text" style="color: #adf802"><span uk-icon="mail"></span> contact@mynextland.com
            </li>
          </div>

          <div class="uk-width-1-6@m uk-width-1-2@s uk-width-1-1">
            <p class="my-footer-content"><b>OUR PROPERTIES</b></p>
            <li><a style="color:#fff" href="{{route('property_listing',['list_as'=>'rent'])}}">For Rent</a></li>
            <li><a style="color:#fff" href="{{route('property_listing',['list_as'=>'sale'])}}">For Sale</a></li>
          </div>
          <div class="uk-width-1-6@m uk-width-1-2@s uk-width-1-1">
            <p class="my-footer-content"><b>INFORMATION</b></p>
            <li><a style="color:#fff" href="#">Terms & Condition</a></li>
            <li><a style="color:#fff" href="#">Privacy</a></li>
            <li><a style="color:#fff" href="#">Disclaimer</a></li>
          </div>
          <div class="uk-width-1-6@m uk-width-1-2@s uk-width-1-1">
            <p class="my-footer-content"><b>ABOUT</b></p>
            <li><a style="color:#fff" href="#">Company Information</a></li>
            <li><a style="color:#fff" href="#">Careers</a></li>
          </div>
          <div class="uk-width-1-5@m uk-width-1-2@s uk-width-1-1">
            <form>
              <p class="my-footer-content"><b>NEWSLETTER</b></p>
              <div class="uk-margin-top ">
                <div class="uk-inline">
                  <button style="background-color:#87ceeb;border: none; "
                    class="uk-form-icon uk-form-icon-flip remove-highlight" type="button"><i class="white-text" uk-icon="icon:forward"></i></button>
                  <input class="uk-input" type="email" placeholder="Email Address">
                </div>
              </div>
              <li style="color: white; font-size:0.8em"> Get recent updates from us...</li>
              <p>
                <a href="" class="uk-icon-button uk-margin-small-right" uk-icon="twitter"
                  style="color: white; background-color: #87ceeb;"></a>
                <a href="" class="uk-icon-button  uk-margin-small-right blue" uk-icon="facebook"
                  style="color: white;"></a>
                <a href="" class="uk-icon-button uk-margin-small-right green" uk-icon="whatsapp"
                  style="color: white;"></a>
                <a href="" class="uk-icon-button uk-margin-small-right" uk-icon="instagram"
                  style="color: white; background-color:#DB7093"></a>
              </p>
            </form>
          </div>
        </div>
      </div>



      <div class="uk-text-center black uk-padding-small" style="color: white;">
        <p class=" uk-margin-remove-vertical" style="font-size:0.8em; opacity: 0.8;">© Copyright 2020 mynextland. All
          Rights Reserved</p>
        <p class="uk-text-small uk-text-muted uk-margin-remove-vertical">All Photos On This Site Are From Properties
          Owners</p>
      </div>

    </footer>
  </div>

  <!-----userdashboard end here----->
  <script src="{{ asset('js/app.js') }}" defer></script>
  @stack('scripts_bottom')
</body>

</html>
