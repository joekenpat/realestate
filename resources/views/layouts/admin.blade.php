<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#ef5350">
  <meta name="msapplication-TileColor" content="#ef5350">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{asset('images/misc/new_favicon.png')}}" type="image/x-icon">
  <meta name="title" content="{{ config('app.name', 'MyNextLand')}} Admin - @yield('title')">

  <title>{{ config('app.name', 'MyNextLand') }} Admin</title>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>
    .navigation {
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

    html {
      background-color: #f3f3f3;
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
    <nav class="uk-navbar-container  red lighten-1" uk-navbar>
      <div class="uk-navbar-let">
        <a class="uk-navbar-item uk-logo" href="{{route('home')}}"><img
            src="{{asset("/images/misc/new_logo_white.png")}}" style="height: 100px; "></a>
      </div>
      <div class=" uk-navbar-right uk-margin-small-right uk-visible@m">
        <ul class="uk-navbar-nav uk-flex uk-flex-middle">
          <li>
            <a href="{{route('property_listing')}}" class="uk-button uk-width-1-1 btn-bg-none uk-text-bold"
              style="color:white;">All Properties</a>
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
            class="uk-button-small uk-text-bold uk-border-pill uk-margin-small-right white-text green darken-1"> Post
            Property</a>

        </ul>
      </div>
    </nav>
    <div class="uk-grid-collapse" uk-grid>
      <div class="uk-visible@m uk-width-1-5 uk-card ">
        <div class="uk-card-default uk-card-body grey darken-1 white-text">
          <ul class="uk-nav-default uk-list-divider uk-nav-parent-icon" uk-nav>
            <li class="uk-active"><a class="white-text" href="{{route('admin_overview')}}"><span
                  class="uk-margin-small-right" uk-icon="icon: settings"></span>
                Overview</a></li>
            <li class="uk-parent ">
              <a class="white-text" href="#"><span class="uk-margin-small-right " uk-icon="icon: home"></span>
                Property</a>
              <ul class="uk-nav-sub">
                <li><a class="white-text" href="{{route('admin_all_properties')}}">All</a></li>
                <li><a class="white-text" href="{{route('admin_pending_properties')}}">Pending</a></li>
                <li><a class="white-text" href="{{route('admin_active_properties')}}">Active</a></li>
                <li><a class="white-text" href="{{route('admin_declined_properties')}}">Declined</a></li>
                <li><a class="white-text" href="{{route('admin_closed_properties')}}">Closed</a></li>
                <li><a class="white-text" href="{{route('admin_expired_properties')}}">Expired</a></li>
                <li><a class="white-text" href="{{route('admin_disabled_properties')}}">Disabled</a></li>
                <li><a class="white-text" href="{{route('admin_reported_properties')}}">Reported</a></li>
              </ul>
            </li>
            <li class="uk-parent">
              <a class="white-text" href="#"><span class="uk-margin-small-right" uk-icon="icon: users"></span> User</a>
              <ul class="uk-nav-sub">
                <li><a class="white-text" href="{{route('admin_all_users')}}">All</a></li>
                <li><a class="white-text" href="{{route('admin_active_users')}}">Active</a></li>
                <li><a class="white-text" href="{{route('admin_blocked_users')}}">Blocked</a></li>
                <li><a class="white-text" href="{{route('admin_agent_users')}}">Agent</a></li>
                <li><a class="white-text" href="{{route('admin_verified_users')}}">Verified</a></li>
                <li><a class="white-text" href="{{route('admin_unverified_users')}}">Unverified</a></li>
              </ul>
            </li>
            <li class="uk-parent">
              <a class="white-text" href="#"><span class="uk-margin-small-right" uk-icon="icon: grid"></span>
                Category</a>
              <ul class="uk-nav-sub">
                <li><a class="white-text" href="{{route('admin_all_categories')}}">All</a></li>
                <li><a class="white-text" href="{{route('admin_new_category')}}">Create New</a></li>
              </ul>
            </li>
            <li class="uk-parent">
              <a class="white-text" href="#"><span class="uk-margin-small-right" uk-icon="icon: list"></span> Sub
                Category</a>
              <ul class="uk-nav-sub">
                <li><a class="white-text" href="{{route('admin_all_subcategories')}}">All</a></li>
                <li><a class="white-text" href="{{route('admin_new_subcategory')}}">Create New</a></li>
              </ul>
            </li>
            <li class="uk-parent">
              <a class="white-text" href="#"><span class="uk-margin-small-right" uk-icon="icon: album"></span> Post</a>
              <ul class="uk-nav-sub">
                <li><a class="white-text" href="#">All</a></li>
                <li><a class="white-text" href="#">Create New</a></li>
              </ul>
            </li>
            <li class="uk-parent">
              <a class="white-text" href="#"><span class="uk-margin-small-right" uk-icon="icon: warning"></span>
                Reports</a>
              <ul class="uk-nav-sub">
                <li><a class="white-text" href="{{route('admin_all_reports')}}">All</a></li>
                <li><a class="white-text" href="{{route('admin_pending_reports')}}">Pending</a></li>
                <li><a class="white-text" href="{{route('admin_resolved_reports')}}">Resolved</a></li>
              </ul>
            </li>
            <li class="uk-parent">
              <a class="white-text" href="#"><span class="uk-margin-small-right" uk-icon="icon: cog"></span>
                Settings</a>
              <ul class="uk-nav-sub">
                <li><a class="white-text" href="{{route('admin_media_settings')}}">Media</a></li>
                <li><a class="white-text" href="{{route('admin_property_settings')}}">Package</a></li>
                <li><a class="white-text" href="{{route('admin_payment_settings')}}">Payments</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <div class="uk-width-1-1 uk-width-4-5@m">
        <div class=" uk-padding-small">
          @if (session('info'))
          <div class="uk-alert-primary" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>{{ session('info') }}</p>
          </div>
          @endif
          @if(session('success'))
          <div class="uk-alert-success" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>{{ session('success') }}</p>
          </div>
          @endif
          @if(session('error'))
          <div class="uk-alert-danger" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>{{session('error')}}</p>
          </div>
          @endif
          @yield('content')
        </div>
      </div>
    </div>


  </div>

  <!-----userdashboard end here----->
  <script src="{{mix('/js/manifest.js')}}" defer></script>
  <script src="{{mix('/js/vendor.js')}}" defer></script>
  <script src="{{mix('/js/app.js')}}" defer></script>
  @stack('scripts_bottom')
</body>

</html>
