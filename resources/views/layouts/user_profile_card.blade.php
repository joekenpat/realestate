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
      <li class="" style="padding: .4em .1em .2em .1em"><a href="{{route('user_create_property')}}"><i
            class="mdi  mdi-telegram" style="color:#adf802; "></i><b class="dashboard-link">Post Ads
          </b></a></li>
      <li class="" style="padding: .4em .1em .2em .1em"><a href="{{route('edit_profile')}}"><i class="mdi  mdi-account"
            style="color:#adf802; "></i><b class="dashboard-link">Edit
            Profile</b></a></li>
      <li class="" style="padding: .4em .1em .2em .1em"><a href="{{route('user_list_property')}}"><i
            class="mdi  mdi-diamond-stone" style="color:#adf802;"></i><b class="dashboard-link">My Ads</b></a>
      </li>
      <li class="" style="padding: .4em .1em .2em .1em"><a href="{{route('user_favourite_property')}}"><i
            class="mdi  mdi-heart" style="color:#adf802; "></i><b class="dashboard-link">My
            Favourite</b></a></li>
      @if(Auth::user()->is_agent())
      <li class="" style="padding: .4em .1em .2em .1em"><a href="{{route('user_property_view')}}"><i
            class="mdi  mdi-heart" style="color:#adf802; "></i><b class="dashboard-link">Property Views</b></a></li>
      @endif
      <li class="" style="padding: .4em .1em .2em .1em"><a href="{{route('user_list_transaction')}}"><i
            class="mdi  mdi-credit-card-outline" style="color:#adf802; "></i><b class="dashboard-link">Payment</b></a>
      </li>

    </ul>
  </div>
</div>
