<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="" type="image/x-icon">

  <title>{{ config('app.name', 'MyNextLand') }}</title>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>
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
    <div class="uk-grid-collapse" uk-grid>
      <div class="uk-visible@m uk-width-1-5 uk-card ">
        <div class="uk-card-default uk-card-body">
          <ul class="uk-nav-default uk-list-divider uk-nav-parent-icon" uk-nav>
            <li class="uk-active"><a href="{{route('admin_overview')}}"><span class="uk-margin-small-right"
                  uk-icon="icon: settings"></span>
                Overview</a></li>
            <li class="uk-parent">
              <a href="#"><span class="uk-margin-small-right" uk-icon="icon: home"></span> Property</a>
              <ul class="uk-nav-sub">
                <li><a href="{{route('admin_all_properties')}}">All</a></li>
                <li><a href="{{route('admin_pending_properties')}}">Pending</a></li>
                <li><a href="{{route('admin_active_properties')}}">Active</a></li>
                <li><a href="{{route('admin_declined_properties')}}">Declined</a></li>
                <li><a href="{{route('admin_closed_properties')}}">Closed</a></li>
                <li><a href="{{route('admin_expired_properties')}}">Expired</a></li>
                <li><a href="{{route('admin_disabled_properties')}}">Disabled</a></li>
                <li><a href="{{route('admin_reported_properties')}}">Reported</a></li>
              </ul>
            </li>
            <li class="uk-parent">
              <a href="#"><span class="uk-margin-small-right" uk-icon="icon: users"></span> User</a>
              <ul class="uk-nav-sub">
                <li><a href="{{route('admin_all_users')}}">All</a></li>
                <li><a href="{{route('admin_active_users')}}">Active</a></li>
                <li><a href="{{route('admin_blocked_users')}}">Blocked</a></li>
                <li><a href="{{route('admin_agent_users')}}">Agent</a></li>
                <li><a href="{{route('admin_verified_users')}}">Verified</a></li>
                <li><a href="{{route('admin_unverified_users')}}">Unverified</a></li>
              </ul>
            </li>
            <li class="uk-parent">
              <a href="#"><span class="uk-margin-small-right" uk-icon="icon: grid"></span> Category</a>
              <ul class="uk-nav-sub">
                <li><a href="{{route('admin_all_categories')}}">All</a></li>
                <li><a href="{{route('admin_new_category')}}">Create New</a></li>
              </ul>
            </li>
            <li class="uk-parent">
              <a href="#"><span class="uk-margin-small-right" uk-icon="icon: list"></span> Sub Category</a>
              <ul class="uk-nav-sub">
                <li><a href="{{route('admin_all_subcategories')}}">All</a></li>
                <li><a href="{{route('admin_new_subcategory')}}">Create New</a></li>
              </ul>
            </li>
            <li class="uk-parent">
              <a href="#"><span class="uk-margin-small-right" uk-icon="icon: album"></span> Post</a>
              <ul class="uk-nav-sub">
                <li><a href="#">All</a></li>
                <li><a href="#">Create New</a></li>
              </ul>
            </li>
            <li class="uk-parent">
              <a href="#"><span class="uk-margin-small-right" uk-icon="icon: warning"></span> Reports</a>
              <ul class="uk-nav-sub">
                <li><a href="{{route('admin_all_reports')}}">All</a></li>
                <li><a href="{{route('admin_pending_reports')}}">Pending</a></li>
                <li><a href="{{route('admin_resolved_reports')}}">Resolved</a></li>
              </ul>
            </li>
            <li class="uk-parent">
              <a href="#"><span class="uk-margin-small-right" uk-icon="icon: cog"></span> Settings</a>
              <ul class="uk-nav-sub">
                <li><a href="{{route('admin_media_settings')}}">Media</a></li>
                <li><a href="{{route('admin_property_settings')}}">Property</a></li>
                {{-- <li><a href="{{route('admin_payment_settings')}}">Payments</a></li> --}}
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <div class="uk-width-1-1 uk-width-4-5@m">
        <div class=" uk-padding-small">
          @yield('content')
        </div>
      </div>
    </div>


  </div>

  <!-----userdashboard end here----->
  <script src="{{ asset('js/app.js') }}" defer></script>
  @stack('scripts_bottom')
</body>

</html>
