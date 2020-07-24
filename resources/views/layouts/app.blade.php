<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>
    @media (max-width: 740px) {
      .my-slide {
        padding-top: none
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



    .footer {
      background-color: none;
    }
  </style>
  @stack('style_top')
  @stack('scripts_top')
</head>

<body>
  <div id="app">
    <!----offcanvas start here---->
    <div id="offcanvas-push" uk-offcanvas="mode: push; overlay: true">
      <div class="uk-offcanvas-bar sidenav ">

        <!-----usefull links ends here---->
        <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
          <li class="uk-parent">
            <a href="#"><b>Menu</b></a>
            <ul class="uk-nav-sub">

              <ul>
                <li>
                  <div class="uk-padding-small">
                    <a href="#"> <button class=" uk-animation-shake uk-button uk-button-large"
                        style="background-color:black;  color:white;max-height: 50px !important; min-height: 50px !important; height:50px; width: 100%"><b>HOME</b></button></a>
                  </div>
                </li>
                <li>
                  <div class="uk-padding-small">
                    <a href="#"> <button class=" uk-animation-shake uk-button uk-button-large"
                        style="background-color:black;  color:white;max-height: 50px !important; min-height: 50px !important; height:50px; width: 100%"><b>PRICING</b></button></a>
                  </div>
                </li>
                <li>
                  <div class="uk-padding-small">
                    <a href="#"> <button class=" uk-animation-shake uk-button uk-button-large"
                        style="background-color:black;   color:white;max-height: 50px !important; min-height: 50px !important; height:50px; width: 100%"><b>ABOUT
                          US
                        </b></button></a>
                  </div>
                </li>
                <li>
                  <div class="uk-padding-small">
                    <a href="#"> <button class=" uk-animation-shake uk-button uk-button-large"
                        style="background-color:black;   color:white;max-height: 50px !important; min-height: 50px !important; height:50px; width: 100%"><b>CONTACT
                          US
                        </b></button></a>
                  </div>
                </li>
                <li>
                  <div class="uk-padding-small">
                    <a href="#"> <button class=" uk-animation-shake uk-button uk-button-large"
                        style="background-color:black; color:white;max-height: 50px !important; min-height: 50px !important; height:50px; width: 100%"><b>Blog
                        </b></button></a>
                  </div>
                </li>
              </ul>
          </li>
        </ul>
        </li>

        </ul>
        <div class="uk-padding-remove">
          <hr>
        </div>

        <!-----usefull links ends here---->
        <ul class="uk-nav uk-nav-default">
          <div class="uk-padding-small">
            <a href="#"> <button class=" uk-animation-shake uk-button uk-button-large"
                style="background-color:black;  color:white;max-height: 50px !important; min-height: 50px !important; height:50px; width: 100%"><b>EDIT
                  PROFILE</b></button></a>
          </div>
        </ul>
        <ul class="uk-nav uk-nav-default">
          <div class="uk-padding-small">
            <a href="#"> <button class=" uk-animation-shake uk-button uk-button-large"
                style="background-color:black;   color:white;max-height: 50px !important; min-height: 50px !important; height:50px; width: 100%"><b>MY
                  ADS
                </b></button></a>
          </div>
        </ul>
        <ul class="uk-nav uk-nav-default">
          <div class="uk-padding-small">
            <a href="#"> <button class=" uk-animation-shake uk-button uk-button-large"
                style="background-color:black; color:white;max-height: 50px !important; min-height: 50px !important; height:50px; width: 100%"><b>MY
                  FAVOURITE
                </b></button></a>
          </div>
        </ul>
        <ul class="uk-nav uk-nav-default">
          <div class="uk-padding-small">
            <a href="#"> <button class=" uk-animation-shake uk-button uk-button-large"
                style="background-color:black; color:white;max-height: 50px !important; min-height: 50px !important; height:50px; width: 100%"><b>PAYMENT
                </b></button></a>
          </div>
        </ul>

        <ul class="uk-nav uk-nav-default">
          <div class="uk-padding-small">
            <a href="{{route('user_create_product')}}"> <button class=" uk-animation-shake uk-button uk-button-large"
                style="background-color:black;color:white;max-height: 50px !important; min-height: 50px !important; height:50px; width: 100%"><b>POST
                  ADS</b></button></a>
          </div>
        </ul>

        <ul class="uk-nav uk-nav-default">
          <div class="uk-padding-small">
            <a href="#"> <button class=" uk-animation-shake uk-button uk-button-large"
                style="background-color:red; color:white;max-height: 50px !important; min-height: 50px !important; height:50px; width: 100%"><b>LOG
                  OUT
                </b></button></a>
          </div>
        </ul>

      </div>
    </div>
    <!----offcanvas ended here---->

    <!----navbar start here ---->
    <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
      <nav class="uk-navbar-container  navigation uk-visible@s" uk-navbar>
        <div class="uk-navbar-let">
          <a class="uk-navbar-item uk-logo" href="{{route('home')}}"><img src="{{asset("/images/misc/logo.png")}}"
              style="height: 100px; "></a>
        </div>

        <div class="uk-navbar-left uk-visible@s">
          <ul class="uk-navbar-nav">

          </ul>
        </div>

        <div class="uk-navbar-right uk-visible@s">
          <ul class="uk-navbar-nav uk-flex uk-flex-middle">
            <li>
              <a href="{{route('home')}}" class="uk-button uk-width-1-1 btn-bg-none uk-text-bold"
                style="color:white;">Home</a>
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
            <a href="{{route('user_create_product')}}"
              style="background-color:#00a86b;color:#fff;height:35px !important;padding-top:5px;"
              class="uk-button-small uk-text-bold uk-border-pill uk-margin-small-right"><i uk-icon="icon:play"
                style="color:#fff;"></i> Post Ad</a>
            @guest
            <a href="{{route('login')}}"
              style="background-color:#fff;color:#00;height:35px !important;padding-top:5px;"
              class="uk-button-small uk-text-bold uk-border-pill uk-margin-small-right"><i uk-icon="icon:sign-in"
                style="color:#f00;"></i> Login</a>
            <a href="{{route('register')}}"
              style="background-color:#f00;color:white;height:35px !important;padding-top:5px;"
              class="uk-button-small uk-text-bold uk-border-pill uk-margin-small-right"><i uk-icon="icon:user"
                style="color:white;"></i> Register</a>
            @endguest
          </ul>
        </div>
        <div class="uk-navbar-right uk-visible@s">
          <ul class="uk-navbar-nav">

          </ul>
        </div>

      </nav>
    </div>
    <!----navbar ends here ---->

    <!---------offcanva for desktop end here----------->

    <!----navbar for mobile start here ---->
    <nav class="uk-navbar-container   navigation-small uk-hidden@s" uk-navbar>
      <div class="uk-navbar-let">
        <a class="uk-navbar-item uk-logo" href="#"><img src="images/logo.png" style="height: 100px;  "></a>
      </div>

      <div class="uk-navbar-right ">
        <ul class="uk-navbar-nav">
          <li>
            <div class="uk-navbar-toggle " uk-toggle="target: #offcanvas-push">
              <i class="mdi  mdi-backburger"
                style="color:white; font-size: 30px;position: fixed;background-color: black;  z-index: 1; padding-right: 20px"></i>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!----navbar for mobile ends here ---->

    <!-----dashboard start here----->

    <main>
      @yield('content')
    </main>
  </div>

  <!-----userdashboard end here----->
  <script src="{{ asset('js/app.js') }}" defer></script>
  @stack('scripts_bottom')
</body>

</html>
